<?php
namespace O3Co\Crawler\Traverser\Node;

use O3Co\Crawler\Traverser\Traversal;
use O3Co\Crawler\Traverser\Handler;

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
