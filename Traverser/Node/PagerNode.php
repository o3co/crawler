<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\Traversal;

class PagerNode extends ConditionalNode 
{
	const KEY_COUNT = 'pager.count';
	protected function doTraverse(Traversal $traversal)
	{
		$count= 1;
		while(1) {
			$traversal->set(self::KEY_COUNT, $count);
			
			$this->getRootHandler()->handle($traversal);

			if(!$this->getCondition($traversal)) {
				break;
			}

			$count++;
		} 
	}

	public function next(\Closure $condition)
	{
		return $this->condition($condition); 
	}
}

