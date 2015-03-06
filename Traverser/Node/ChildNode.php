<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\Node;
use O3Com\Crawler\Traverser\Traversal;
use O3Com\Crawler\Traverser\Handler;

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

	public function getForm(Traversal $traversal)
	{
		$contentNode = $this->getContentNode();
		if(!$contentNode instanceof FormNode) {
			throw new \InvalidArgumentException('getForm only supported in FormNode.');
		}
		return $contentNode->getForm($traversal);
	}

	public function getFormValues(Traversal $traversal)
	{
		$contentNode = $this->getContentNode();
		if(!$contentNode instanceof FormNode) {
			throw new \InvalidArgumentException('getFormValues only supported in FormNode.');
		}
		return $contentNode->getFormValues($traversal);
	}

	public function setData($data)
	{
		$contentNode = $this->getContentNode();
		if(!$contentNode instanceof FormNode) {
			throw new \RuntimeException('ConditionalNode::setData is only accepted under FormNode.');
		}

		$contentNode->initSetDataHandlers($this, $data);
		return $this;
	}

	public function set($key, $value) 
	{
		if(!$this->getContentNode() instanceof FormNode) {
			throw new \RuntimeException('ConditionalNode::set is only accepted under FormNode.');
		}

		$this->getContentNode()->initSetHandlers($this, $key, $value);
		return $this;
	}

	public function send($action = null, $method = null, \Closure $send = null)
	{
		if(!$this->getContentNode() instanceof FormNode) {
			throw new \RuntimeException('ConditionalNode::submit is only accepted under FormNode.');
		}

		$page = $this->getNodeFactory()->createPageNode($this);
		$this->getHandlers()->append(new Handler\NodeHandler($page));

		$this->getContentNode()->initSendValueHandlers($page, $action, $method, $send);
		return $page;
	}

	public function submit($action = null, $method = null)
	{
		if(!$this->getContentNode() instanceof FormNode) {
			throw new \RuntimeException('ConditionalNode::submit is only accepted under FormNode.');
		}

		$page = $this->getNodeFactory()->createPageNode($this);
		$this->getHandlers()->append(new Handler\NodeHandler($page));

		$this->getContentNode()->initSubmitHandlers($page, $action, $method);
		return $page;
	}

	public function getCrawler(Traversal $traversal)
	{
		return $this->getContentNode()->getCrawler($traversal);
	}

	public function getContentNode()
	{
		if($this instanceof ContentNode) {
			return $this;
		}
		return $this->getParentNode()->getContentNode();
	}
}

