<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\Node;
use O3Com\Crawler\Traverser\Handler;
use O3Com\Crawler\Traverser\Traversal;

/**
 * PartialNode 
 *   Node for in page partial 
 * 
 * @uses AbstractNode
 * @abstract
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
abstract class PartialNode extends ContentNode 
{
	private $selector;

	public function __construct(Node $parentNode, $selector)
	{
		parent::__construct($parentNode);

		$this->selector = $selector;
	}

	/**
	 * end 
	 *   Back to parent node 
	 * @access public
	 * @return void
	 */
	public function end()
	{
		return $this->getParentNode();
	}

	public function getCrawler(Traversal $traversal)
	{
		try {
			return $this->getParentNode()->getCrawler($traversal)->filter($this->getSelector($traversal));
		} catch(\InvalidArgumentException $ex) {
			throw new CssSelectorException(sprintf('Form "%s" is not exists.', $this->getSelector($traversal)));
		}
	}
    
    public function getSelector(Traversal $traversal)
    {
        $selector = $this->selector;
		if(is_callable($selector)) {
			$selector = $selector($traversal);
		}
		return $selector;
    }
}

