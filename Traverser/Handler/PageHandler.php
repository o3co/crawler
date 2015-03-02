<?php
namespace O3Com\Crawler\Traverser\Handler;

use O3Com\Crawler\Traverser\Handler;
use O3Com\Crawler\Traverser\Traversal;
use O3Com\Crawler\Traverser\Node\PageNode;

class PageHandler extends AbstractHandler 
{
	public function __construct(PageNode $node)
	{
		$this->node = $node;
	}

	protected function doHandle(Traversal $traversal)
	{
		$page = $traversal->enterScope();
		$this->getPage()->traverse($traversal);
	}
}

