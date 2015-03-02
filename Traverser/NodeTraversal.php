<?php
namespace O3Com\Crawler\Traverse;

class NodeTraversal extends AbstractTraversal 
{
	private $_site;

	private $_client;

	public function __construct(Traversal $parentTraversal, Traverser $node, array $configs = array())
	{
		$this->parentTraversal = $parentTraversal;
		$this->node = $node;

		parent::__construct($configs);
	}

	public function getClient()
	{
		if(!$this->_client) {
			$this->_client = $this->getParentTraversal()->getClient();
		}
		return $this->_client;
	}

	public function getSite()
	{
		if(!$this->_site) {
			$this->_site = $this->getParentTraversal()->getSite();
		}
		return $this->_site;
	}
}

