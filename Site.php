<?php
namespace O3Com\Crawler;

use O3Com\Crawler\Traverser;
use O3Com\Crawler\Traverser\Node;
use O3Com\Crawler\Traverser\SiteTraversal;

use O3Com\Crawler\Client;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;

use O3Com\Crawler\Traverser\Node\Factory\DefaultNodeFactory;
use O3Com\Crawler\Exception\TerminateException;

/**
 * Site 
 * 
 * @uses RootNode
 * @uses Traverser
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class Site 
{
	/**
	 * root 
	 * 
	 * @var RootNode 
	 * @access private
	 */
	private $root;

	/**
	 * triggerHandlers 
	 * 
	 * @var array
	 * @access private
	 */
	private $triggers = array();

	/**
	 * eventDispatcher 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $eventDispatcher;

	/**
	 * initialized 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $initialized;

	/**
	 * nodeFactory 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $nodeFactory;

	public function __construct()
	{
		$this->root = new Node\RootNode($this);
		$this->triggers = array();
		$this->eventDispatcher = null;
	}

	public function init(array $configs = array())
	{
		if(!$this->initialized) {
			$this->registerDefaultTriggers();

			$this->doInit($configs);

			$this->initialized = true;
		}

		return $this;
	}

	protected function registerDefaultTriggers()
	{
		$this
			->addTrigger('dump', function($traversal, $path) {
					if(is_callable($path)) {
						$path = $path($traversal);
					}

					file_put_contents($path, (string)$traversal->getCurrentPage()->getResponse()->getContent());
				})
			->addTrigger('download', function($traversal, $urls, \Closure $postCallback) {
					if(is_callable($urls)) {
						$urls = $urls($traversal);
					}
					$urls = (array)$urls;

					$files = $traversal->getClient()->download($urls);

					$postCallback($files, $traversal);
				})
			->addTrigger('terminate', function($traversal) {
					throw new TerminateException('terminated');
				})
			->addTriggers(new Trigger\CookieTriggerSubscriber())
		;
	}

	public function isInitialized()
	{
		return (bool)$this->initialized;
	}

	public function hasTrigger($name)
	{
		return isset($this->triggers[$name]);
	}

	/**
	 * addTrigger 
	 * 
	 * @param mixed $name 
	 * @param \Closure $handler 
	 * @access public
	 * @return void
	 */
	public function addTrigger($name, \Closure $handler)
	{
		$this->triggers[$name] = $handler;
		return $this;
	}

	public function addTriggers(TriggerSubscriber $subscriber)
	{
		foreach($subscriber->getSubscribedTriggers() as $name => $trigger) {
			if(is_callable($trigger)) {
				$this->triggers[$name] = $trigger;
			} else {
				$this->triggers[$name] = array($subscriber, $trigger);
			}
		}
		return $this;
	}

	/**
	 * getTriggerHandler 
	 * 
	 * @param mixed $name 
	 * @access public
	 * @return void
	 */
	public function getTrigger($name)
	{
		if(!isset($this->triggers[$name])) {
			throw new \InvalidArgumentException(sprintf('Trigger "%s" is not registered.', $name));
		}
		return $this->triggers[$name];
	}

	/**
	 * root 
	 * 
	 * @access public
	 * @return void
	 */
	public function root()
	{
		return $this->root;
	}

	/**
	 * visit 
	 * 
	 * @param mixed $url 
	 * @param string $method 
	 * @access public
	 * @return void
	 */
	public function visit($url, $method = 'GET')
	{
		return $this->root->visit($url, $method);
	}

	/**
	 * traverse 
	 * 
	 * @param mixed $client 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public function traverse($client = null, array $options = array())
	{
		// initialize without configurations 
		if(!$this->initialized) {
			$this->init();
		}

		if(!$client) {
			$client = new Client();
		}

		$traversal = new SiteTraversal($this, $client, $options);

		//$traversal->init();
		
		$this->root->traverse($traversal);

		return $traversal;
	}
    
    public function getEventDispatcher()
    {
		if(!$this->eventDispatcher) {
			$this->eventDispatcher = new EventDispatcher();
		}
        return $this->eventDispatcher;
    }
    
    public function setEventDispatcher($eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        return $this;
    }

	public function addListener($eventname, $listener, $priority = 0)
	{
		$this->getEventDispatcher()->addListener($eventname, $listener, $priority);
		return $this;
	}

	public function getNodeFactory()
	{
		if(!$this->nodeFactory) {
			$this->nodeFactory = new DefaultNodeFactory(); 
		}

		return $this->nodeFactory;
	}

	public function dispatch($eventName, Event $event)
	{
		$this->getEventDispatcher()->dispatch($eventName, $event);
	}

	public function setNodeFactory(NodeFactory $factory)
	{
		$this->nodeFactory = $factory;	
	}

	public function onException(\Closure $callback)
	{
		$this->root->onException($callback);
		return $this;
	}
}
