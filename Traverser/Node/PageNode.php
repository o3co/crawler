<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\Handler;
use O3Com\Crawler\Traverser\Traversal;

/**
 * PageNode 
 * 
 * @uses ChildNode
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class PageNode extends ContentNode 
{
	public function back()
	{
		return $this->getParentNode();
	}

	public function getCrawler(Traversal $traversal)
	{
		return $traversal->getCurrentPage()->getCrawler();
	}
}

