<?php
namespace O3Co\Crawler\Traverser\Node;

use O3Co\Crawler\Traverser\Handler;
use O3Co\Crawler\Traverser\Traversal;

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

