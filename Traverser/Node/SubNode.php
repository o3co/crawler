<?php
BehaveNode
BehaviorNode
SpecifiedNode
Block
ConditionalNode ConditionNode
DecorateNode
InPageNode 
AccessNode

abstract class ConditionNode extends AbstractNode 
{
	public function end()
	{
		return $this->getParentNode();
	}
}

