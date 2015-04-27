<?php
namespace O3Co\Crawler\Traverser\Handler;

use O3Co\Crawler\Traverser\Node;
use O3Co\Crawler\Traverser\Handler;
use O3Co\Crawler\Traverser\Traversal;
use O3Co\Crawler\Traverser\Node\PageNode;

/**
 * NodeHandler 
 *   Call Node::traverse 
 * @uses AbstractHandler
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class NodeHandler extends AbstractHandler 
{
	private $node;

	public function __construct(Node $node)
	{
		$this->node = $node;
	}

	protected function doHandle(Traversal $traversal)
	{
		$traverser = $traversal->get('traverser');

		$traversal->set('traverser', $this->node);
		$this->getNode()->traverse($traversal);
		$traversal->set('traverser', $traverser);
	}
    
    public function getNode()
    {
        return $this->node;
    }
    
    public function setNode(Node $node)
    {
        $this->node = $node;
        return $this;
    }
}
