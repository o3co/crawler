<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\Traversal;
use O3Com\Crawler\Traverser\Handler;

class ScopeNode extends ChildNode 
{
	public function getCrawler(Traversal $traversal)
	{
		return $this->getParentNode()->getCrawler($traversal);
	}

	public function end()
	{
		return $this->getParentNode();
	}
}
