<?php
namespace O3Co\Crawler\Traverser;

use O3Co\Crawler\Traverser;
use O3Co\Crawler\Traverser\Traversal;
use O3Co\Crawler\Event\TraversalEvents,
	O3Co\Crawler\Event\TraversalEvent
;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use O3Co\Crawler\Exception\TerminateException;

/**
 * AbstractTraverser 
 * 
 * @uses Traverser
 * @abstract
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
abstract class AbstractTraverser implements Traverser
{
	private $listeners;

	private $uid;

	public function __construct()
	{
		$this->listeners = array();
		$this->uid = uniqid();
	}

	public function traverse(Traversal $traversal)
	{
		$this->attachListeners($traversal->getEventDispatcher());

		try {
	
			// open page
			$this->enterTraverse($traversal);
	
			// do traverse
			try {
				$this->dispatch($traversal->getEventDispatcher(), TraversalEvents::onPreTraverse, new TraversalEvent($traversal));
	
				$this->doTraverse($traversal);
	
				$this->dispatch($traversal->getEventDispatcher(), TraversalEvents::onPostTraverse, new TraversalEvent($traversal));


				$this->dispatch($traversal->getEventDispatcher(), TraversalEvents::onResponse, new TraversalEvent($traversal));

			} catch(TerminateException $ex) {
				throw $ex;
			} catch(\Exception $ex) {
				// close
				try {
					$this->leaveTraverse($traversal);
				} catch(\Exception $e) {
					throw new TerminateException('Failed to close the traverser.', 0, $ex);
				}
				throw $ex;
			}
			// close
			$this->leaveTraverse($traversal);
		} catch(\Exception $ex) {
			try {
				$this->dispatch($traversal->getEventDispatcher(), TraversalEvents::onException, new TraversalEvent($traversal, array('exception' => $ex)));
			} catch(\Exception $ex) {
				// If any exception thrown in Exception handler, then detach the listeners and throw the exception
				$this->detachListeners($traversal->getEventDispatcher());
				throw $ex;
			}

			$this->detachListeners($traversal->getEventDispatcher());
			throw $ex;
		}

		$this->detachListeners($traversal->getEventDispatcher());
	}
	
	protected function enterTraverse(Traversal $traversal)
	{
		$this->dispatch($traversal->getEventDispatcher(), TraversalEvents::onEnterTraverse, new TraversalEvent($traversal, array('traverser' => $this)));
	}

	protected function leaveTraverse(Traversal $traversal)
	{
		$this->dispatch($traversal->getEventDispatcher(), TraversalEvents::onLeaveTraverse, new TraversalEvent($traversal, array('traverser' => $this)));
	}

	abstract protected function doTraverse(Traversal $traversal);

	public function attachListeners(EventDispatcherInterface $dispatcher)
	{
		foreach($this->listeners as $eventname => $listeners) {
			foreach($listeners as $priority => $priListeners) {
				foreach($priListeners as $listener) {
					$dispatcher->addListener($eventname, $listener, $priority);
				}
			}
		}
	}

	public function detachListeners(EventDispatcherInterface $dispatcher)
	{
		foreach($this->listeners as $eventname => $listeners) {
			foreach($listeners as $priority => $priListeners) {
				foreach($priListeners as $listener) {
					$dispatcher->removeListener($eventname, $listener, $priority);
				}
			}
		}
	}

	public function dispatch(EventDispatcherInterface $dispatcher, $eventname, $event)
	{
		$dispatcher->dispatch($this->getUid() . '.' . $eventname, $event);
		$dispatcher->dispatch($eventname, $event);

		return $event;
	}

	public function addListener($event, $listener, $priority = 0)
	{
		$onPageEventName = $this->getUid() . '.' . $event;

		$this->addGlobalListener($onPageEventName, $listener, $priority);
		return $this;
	}

	public function addGlobalListener($eventname, $listener, $priority = 0)
	{
		if(!isset($this->listeners[$eventname])) {
			$this->listeners[$eventname] = array();
		}
		if(!isset($this->listeners[$eventname][$priority])) {
			$this->listeners[$eventname][$priority] = array();
		}

		$this->listeners[$eventname][$priority][] = $listener;
		return $this;
	}

	public function onPreTraverse($listener, $priority = 0)
	{
		return $this->addListener(TraversalEvents::onPreTraverse, function($event) use ($listener) {
				$listener($event->getTraversal(), $event);
			}, $priority);
	}

	public function onPostTraverse($listener, $priority = 0)
	{
		return $this->addListener(TraversalEvents::onPostTraverse, function($event) use ($listener) {
				$listener($event->getTraversal(),$event);
			}, $priority);
	}

	public function onPreTraverseGlobal($listener, $priority = 0)
	{
		return $this->addGlobalListener(TraversalEvents::onPreTraverse, function($event) use ($listener) {
				$listener($event->getTraversal(),$event);
			}, $priority);
	}

	public function onPostTraverseGlobal($listener, $priority = 0)
	{
		return $this->addGlobalListener(TraversalEvents::onPostTraverse, function($event) use ($listener) {
				$listener($event->getTraversal(),$event);
			}, $priority);
	}

	public function onEnterTraverse($listener, $priority = 0)
	{
		return $this->addListener(TraversalEvents::onEnterTraverse, function($event) use ($listener) {
				$listener($event->getTraversal(),$event);
			}, $priority);
	}
	
	public function onLeaveTraverse($listener, $priority = 0)
	{
		return $this->addListener(TraversalEvents::onLeaveTraverse, function($event) use ($listener) {
				$listener($event->getTraversal(),$event);
			}, $priority);
	}

	public function onException($listener, $priority = 0)
	{
		return $this->addListener(TraversalEvents::onException, function($event)  use ($listener) {
				$listener($event->get('exception'), $event->getTraversal(), $event);
			}, $priority);
	}

	public function onExceptionGlobal($listener, $priority = 0)
	{
		return $this->addGlobalListener(TraversalEvents::onException, function($event)  use ($listener) {
				$listener($event->get('exception'), $event->getTraversal(), $event);
			}, $priority);
	}

	public function onResponse($listener, $priority = 0) 
	{
		return $this->addListener(TraversalEvents::onResponse, function($event)  use ($listener) {
				$listener($event->getTraversal(), $event);
			}, $priority);
	}

	public function onResponseGlobal($listener, $priority = 0) 
	{
		return $this->addGlobalListener(TraversalEvents::onResponse, function($event)  use ($listener) {
				$listener($event->getTraversal(), $event);
			}, $priority);
	}
    
    public function getUid()
    {
        return $this->uid;
    }
}
