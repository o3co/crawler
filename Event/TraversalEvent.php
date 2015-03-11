<?php
namespace O3Co\Crawler\Event;

use O3Co\Crawler\Traverser\Traversal;

/**
 * TraversalEvent 
 * 
 * @uses Event
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class TraversalEvent extends Event 
{
	private $traversal;

	public function __construct(Traversal $traversal, array $args = array())
	{
		parent::__construct($args);
		$this->traversal = $traversal;
	}
    
    public function getTraversal()
    {
        return $this->traversal;
    }
    
    public function setTraversal(Traversal $traversal)
    {
        $this->traversal = $traversal;
        return $this;
    }
}

