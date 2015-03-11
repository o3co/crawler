<?php
namespace O3Co\Crawler\Traverser\Handler;

use O3Co\Crawler\Traverser\Handler;
use O3Co\Crawler\Traverser\Traversal;
use O3Co\Crawler\Exception\SkipException;

/**
 * ExceptionHandler 
 * 
 * @uses AbstractHandler
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class ExceptionHandler extends AbstractHandler
{
	private $handler;

	public function __construct(Handler $handler = null)
	{
		$this->handler = $handler;
	}
	/**
	 * doHandle 
	 * 
	 * @param Traversal $traversal 
	 * @access protected
	 * @return void
	 */
	protected function doHandle(Traversal $traversal)
	{
		try {
			$this->handler->handle($traversal);
		} catch(SkipException $ex) {
			// skip the current handler, but keep the traverse going.
			return;
		}
	}
    
    public function getHandler()
    {
        return $this->handler;
    }
    
    public function setHandler(Handler $handler)
    {
        $this->handler = $handler;
        return $this;
    }
}
