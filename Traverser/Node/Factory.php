<?php
namespace O3Co\Crawler\Traverser\Node;
use O3Co\Crawler\Traverser\Node;

/**
 * Factory 
 * 
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
interface Factory 
{
	function createPageNode(Node $parentNode, array $options = array());

	function createFormNode(Node $parentNode, $selector, array $options = array());
}
