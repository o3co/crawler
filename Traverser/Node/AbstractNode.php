<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\Node;
use O3Com\Crawler\Traverser\Page;
use O3Com\Crawler\Traverser\Traversal;
use O3Com\Crawler\Traverser\AbstractTraverser;
use O3Com\Crawler\Scraper;
use O3Com\Crawler\Exception\SkipException;

use O3Com\Crawler\Traverser\Handler;
use O3Com\Crawler\Event\TraversalEvents;


abstract class AbstractNode extends AbstractTraverser implements Node
{
	private $name;

	protected $rootHandler;

	public function name($name)
	{
		$this->name = $name;
		return $this;
	}

	public function init($closure)
	{
		$this->onPreTraverse($closure);
		return $this;
	}

	public function modify($closure)
	{
		$this->addListener(TraversalEvents::onPreTraverse, function($event) use ($closure) {
				$traversal = $event->getTraversal();
				$crawler = $this->getCrawler($traversal);
				$closure($crawler, $traversal, $event);
			});
		return $this;
	}

	protected function doTraverse(Traversal $traversal)
	{
		return $this->getRootHandler()->handle($traversal);
	}

	protected function initHandlers()
	{
		$this->rootHandler = new Handler\SequentialHandler();
	}

	public function getHandlers()
	{
		return $this->getRootHandler();
	}

	public function getRootHandler()
	{
		if(!$this->rootHandler) {
			$this->initHandlers();
		}
		return $this->rootHandler;
	}

	public function addHandler($handler)
	{
		$this->getHandlers()->addHandler($handler);
	}

	public function visit($url, $method = 'GET', array $options = array())
	{
		$page = $this->getNodeFactory()->createPageNode($this);

		$this->getHandlers()->append(new Handler\NodeHandler($page));

		$page
			->onEnterTraverse(function($traversal) use ($url, $method, $options){
					// visit the page
					$traversal->visit($url, $method, $options);
				})
			->onLeaveTraverse(function($traversal) {
					// leave the page
					$traversal->back();
				})
		;

		return $page;
	}

	/**
	 * form 
	 *   Select form in this page. 
	 * @param mixed $selector 
	 * @access public
	 * @return void
	 */
	public function form($selector)
	{
		$form = $this->getNodeFactory()->createFormNode($this, $selector);

		$this->getHandlers()->append(new Handler\NodeHandler($form));

		return $form;
	}

	public function scrape($scraper, $name = Page::DEFAULT_CONTENT)
	{
		$this->getHandlers()
			->append(new Handler\ScrapeHandler($scraper, $name))
		;

		return $this;
	}

	/**
	 * validate 
	 * 
	 * @param \Closure $condition 
	 * @access public
	 * @return void
	 */
	public function validate(\Closure $condition)
	{
		// add valdiate listener on pre_traverse 
		$this->addListener(TraversalEvents::onPreTraverse, function($event) use ($condition) {
				if(!$condition($traversal)) {
					// Stop  
					throw new SkipException();
				}
			});
	}

	public function each($condition)
	{
		$node = $this->getNodeFactory()->createEachNode($this, $condition);

		$this->getHandlers()
			->append(new Handler\NodeHandler($node))
		;
		return $node;
	}

	public function enter()
	{
		$node = $this->getNodeFactory()->createScopeNode($this);

		$this->getHandlers()
			->append(new Handler\NodeHandler($node))
		;
		return $node;
	}

	public function getNodeFactory()
	{
		return $this->nodeFactory;
	}

	public function execute(\Closure $closure)
	{
		$this->getHandlers()->append(new Handler\ExecuteHandler(function($traversal) use ($closure) {
				$closure($traversal);
			}));
		return $this;
	}

	/**
	 * trigger 
	 * 
	 * @param mixed $name 
	 * @param array $params 
	 * @access public
	 * @return void
	 */
	public function trigger($name, array $params = array())
	{
		$this->getHandlers()->append(new Handler\ExecuteHandler(function($traversal) use ($name, $params){
				$trigger = $traversal->getSite()->getTrigger($name);

				array_unshift($params, $traversal);
				call_user_func_array($trigger, $params);
			}));

		return $this;
	}

	public function __call($method, array $args = array())
	{
		if($this->getSite()->hasTrigger($method)) {
			return $this->trigger($method, $args);
		} else {
			throw new \InvalidArgumentException(sprintf('There is no method or trigger "%s" is not registered.', $method));
		}
	}

}

