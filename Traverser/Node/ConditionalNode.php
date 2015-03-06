<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\Node;
use O3Com\Crawler\Traverser\Handler;
use O3Com\Crawler\Traverser\Traversal;

/**
 * ConditionalNode 
 *   This is a baseclass of any Node to traverse the pages with condition.
 *  
 * @uses AbstractNode
 * @abstract
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
abstract class ConditionalNode extends ChildNode 
{
	const KEY_CONDITION = 'condition';

	private $condition;

	public function __construct(Node $parentNode, $condition = null)
	{
		parent::__construct($parentNode);

		$this->condition = $condition;
	}

	public function traverse(Traversal $traversal)
	{
		$condition = $traversal->get(self::KEY_CONDITION);
		$traversal->set(self::KEY_CONDITION, null);
		parent::traverse($traversal);

		$traversal->set(self::KEY_CONDITION, $condition);
	}

	public function condition($condition)
	{
		$this->condition = $condition;
		return $this;
	}

	public function init($closure)
	{
		$this->getHandlers()->prepend(new Handler\ExecuteHandler($closure));
		return $this;
	}

	/**
	 * end 
	 *   Back to parent node 
	 * @access public
	 * @return void
	 */
	public function end()
	{
		return $this->parentNode;
	}

	/**
	 * getOwner 
	 *   Get Conditional owner 
	 * 
	 * @access public
	 * @return PartialNode|PageNode|RootNode 
	 */
	public function getOwnerNode()
	{
		return $this->getContentNode();
	}
    
    public function getCondition(Traversal $traversal)
    {
		if(is_callable($this->condition)) {
			return call_user_func_array($this->condition, array($traversal, $this->getCrawler($traversal)));
		}
		
		if(!$this->condition) {
			throw new \RuntimeException('ConditionalNode::condition is not specified..');
		}
        return $this->condition;
    }
}

