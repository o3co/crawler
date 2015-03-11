<?php
namespace O3Co\Crawler;

use O3Co\Crawler\Traverser\Traversal;

/**
 * Traverser 
 * 
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
interface Traverser 
{
	/**
	 * traverse 
	 * 
	 * @param Traversal $traversal 
	 * @access public
	 * @return void
	 */
	function traverse(Traversal $traversal);
}

