<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\Node;

/**
 * ChildNode 
 * 
 * @uses AbstractNode
 * @abstract
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
abstract class ChildNode extends AbstractNode 
{
	protected $parentNode;

	public function __construct(Node $parentNode)
	{
		$this->parentNode = $parentNode;

		parent::__construct();
	}
    
    public function getParentNode()
    {
        return $this->parentNode;
    }

	public function getSite()
	{
		return $this->getParentNode()->getSite();
	}
    
    public function setParentNode(Node $parentNode)
    {
        $this->parentNode = $parentNode;
        return $this;
    }

	public function getNodeFactory()
	{
		return $this->getParentNode()->getNodeFactory();
	}

	public function link($selector)
	{
		$page = $this->getNodeFactory()->createPageNode($this);

		$this->getHandlers()->append(new Handler\NodeHandler($page));
		$page
			->onEnterTraverse(function($traversal){
					$traversal->forwardByLink($traversal->getCrawler()->filter($selector)->link());
				})
			->onLeaveTraverse(function($traversal) {
					$traversal->back();
				})
		;

		return $page;
	}
}

