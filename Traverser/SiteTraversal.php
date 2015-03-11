<?php
namespace O3Co\Crawler\Traverser;

use O3Co\Crawler\Site;
use O3Co\Crawler\Client;
use O3Co\Crawler\Event\TraversalEvent,
	O3Co\Crawler\Event\TraversalEvents
;
use O3Co\Crawler\Exception\NoPageException;

class SiteTraversal extends AbstractTraversal implements Traversal 
{
	private $site;

	private $client;

	private $configs;

	private $pageStack;

	public function __construct(Site $site, Client $client = null, array $configs = array())
	{
		$this->site   = $site;
		$this->client = $client;
		$this->pageStack = new \SplStack();
		$this->configs = $configs;
	}

	public function visit($url, $method = 'GET', array $options = array())
	{
		$this->dispatch(TraversalEvents::onPrePageVisit, new TraversalEvent($this));

		$files = array();
		$server = array();
		$content = null;

		if(isset($options['files'])) {
			$files = $options['files'];
			unset($options['files']);
		}
		if(isset($options['server'])) {
			$server = $options['server'];
			unset($options['server']);
		}
		if(isset($options['content'])) {
			$content = $options['content'];
			unset($options['content']);
		}

		$crawler = $this->getClient()->request($method, $url, $options, $files, $server, $content);

		$page = new Page($this->getClient()->getRequest(), $this->getClient()->getResponse(), $crawler);

		$this->dispatch(TraversalEvents::onPostPageVisit, new TraversalEvent($this));

		$this->enterPage($page);
	}

	public function forward($visitor)
	{
		if($visitor instanceof Link) {
			$this->forwardByLink($visitor);
		} else if($visitor instanceof Form) {
			$this->forwardByForm($visitor);
		} else if($visitor instanceof Page) {
			$this->enterPage($visitor);
		}
	}

	public function forwardByLink($link, $pushStack = true)
	{
		$this->dispatch(TraversalEvents::onPrePageVisit, new TraversalEvent($this));
		$crawler = $this->getClient()->click($link);
		$page = new Page($this->getClient()->getRequest(), $this->getClient()->getResponse(), $crawler);
		$this->dispatch(TraversalEvents::onPostPageVisit, new TraversalEvent($this));
		
		if($pushStack)
			$this->enterPage($page);
		return $page;
	}

	public function forwardByForm($form, $pushStack = true)
	{
		$this->dispatch(TraversalEvents::onPrePageVisit, new TraversalEvent($this));
		$crawler = $this->getClient()->submit($form);
		$page = new Page($this->getClient()->getRequest(), $this->getClient()->getResponse(), $crawler);
		$this->dispatch(TraversalEvents::onPostPageVisit, new TraversalEvent($this));

		if($pushStack)
			$this->enterPage($page);
		return $page;
	}

	public function back()
	{
		$this->dispatch('pre_leave', new TraversalEvent($this));

		$this->getClient()->back();
		$this->leavePage();

		$this->dispatch('post_leave', new TraversalEvent($this));
	}

	public function dispatch($eventname, $event)
	{
		$this->getSite()->dispatch($eventname, $event);
	}

	public function getTraverser()
	{
		return $this->get('traverser');
	}
    
    public function getPageStack()
    {
        return $this->pageStack;
    }
    
    public function setPageStack($pageStack)
    {
        $this->pageStack = $pageStack;
        return $this;
    }

	public function enterPage(Page $page)
	{
		$this->pageStack->push($page);
	}

	public function leavePage()
	{
		if(count($this->pageStack) <= 0) {
			throw new NoPageException('Already released all pages.');
		}

		return $this->pageStack->pop();
	}

	public function current()
	{
		return $this->getCurrentPage();
	}

	public function hasCurrentPage()
	{
		return 0 !== ($this->pageStack);
	}

	public function getCurrentPage()
	{
		if(count($this->pageStack) <= 0) {
			throw new NoPageException('Currently no active page exists.');
		}
		return $this->pageStack->top();
	}
     
     public function getClient()
     {
         return $this->client;
     }
     
     public function setClient(Client $client)
     {
         $this->client = $client;
         return $this;
     }
    
    public function getSite()
    {
        return $this->site;
    }

	public function getEventDispatcher()
	{
		return $this->getSite()->getEventDispatcher();
	}

}

