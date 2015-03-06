<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\Traversal;
use O3Com\Crawler\Traverser\Handler;

class IfNode extends ConditionalNode
{
	const KEY_CONDITION = 'if.condition';

	protected function doTraverse(Traversal $traversal)
	{
		$condition = $this->getCondition($traversal);
		
		if($condition) {
			parent::doTraverse($traversal);
		}
	}
}
