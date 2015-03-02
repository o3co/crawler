<?php
namespace O3Com\Crawler\Traverser\Handler;

use O3Com\Crawler\Traverser\Handler;
use O3Com\Crawler\Traverser\Traversal;

/**
 * AbstractHandler 
 * 
 * @uses Handler
 * @abstract
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
abstract class AbstractHandler implements Handler
{
	public function handle(Traversal $traversal)
	{
		$this->doHandle($traversal);
	}

	abstract protected function doHandle(Traversal $traversal);
}
