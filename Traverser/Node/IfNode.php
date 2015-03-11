<?php
namespace O3Co\Crawler\Traverser\Node;

use O3Co\Crawler\Traverser\Traversal;
use O3Co\Crawler\Traverser\Handler;

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
