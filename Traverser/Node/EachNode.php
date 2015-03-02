<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\Traversal;
use O3Com\Crawler\Traverser\Handler;

class EachNode extends ConditionalNode
{
	const KEY_CONDITION = 'each.condition';

	protected function doTraverse(Traversal $traversal)
	{
		$conditions = $this->getCondition($traversal);
		if(!is_array($conditions)) {
			throw new \RuntimeException('EachNode::$condition has to be an array or a callable returned an array.');
		}
		
		$originalValue = $traversal->get(self::KEY_CONDITION, null);
		foreach($conditions as $condition) {
			$traversal->set(self::KEY_CONDITION, $condition);

			parent::doTraverse($traversal);
		}

		$traversal->set(self::KEY_CONDITION, $originalValue);
	}
}
