<?php
namespace O3Com\Crawler\Traverser\Handler;

use O3Com\Crawler\Traverser\Traversal;

/**
 * ExecuteHandler 
 * 
 * @uses AbstractHandler
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class ExecuteHandler extends AbstractHandler
{
	/**
	 * closure 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $closure;

	/**
	 * __construct 
	 * 
	 * @param \Closure $closure 
	 * @access public
	 * @return void
	 */
	public function __construct(\Closure $closure)
	{
		$this->closure = $closure;
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
		$closure = $this->closure;

		$closure($traversal);
	}
}

