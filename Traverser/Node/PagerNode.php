<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\Traversal;

class PagerNode extends ConditionalNode 
{
	protected function doTraverse(Traversal $traversal)
	{
		$count= 1;
		while(1) {
			$traversal->set('pager.count', $count);
			
			$this->getRootHandler()->handle($traversal);

			if(!$condition($traversal, $this->getCrawler($traversal))) {
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

