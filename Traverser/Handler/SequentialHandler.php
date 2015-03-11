<?php
namespace O3Co\Crawler\Traverser\Handler;

use O3Co\Crawler\Traverser\Handler;
use O3Co\Crawler\Traverser\Traversal;

/**
 * SequentialHandler 
 * 
 * @uses Handler
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class SequentialHandler implements Handler 
{
	private $handlers;

	public function __construct()
	{
		$this->handlers = array();
	}

	/**
	 * handle 
	 * 
	 * @param Traversal $traversal 
	 * @access public
	 * @return void
	 */
	public function handle(Traversal $traversal)
	{
		foreach($this->getHandlers() as $handler) {
			$handler->handle($traversal);
		}
	}

	public function addHandler(Handler $handler)
	{
		$this->append($handler);
		return $this;
	}

	public function append(Handler $handler)
	{
		array_push($this->handlers, $handler);
		return $this;
	}

	public function prepend(Handler $handler)
	{
		array_unshift($this->handlers, $handler);
		return $this;
	}
    
    public function getHandlers()
    {
        return $this->handlers;
    }
}

