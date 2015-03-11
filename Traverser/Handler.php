<?php
namespace O3Co\Crawler\Traverser;

/**
 * Handler 
 * 
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
interface Handler
{
	/**
	 * handle 
	 * 
	 * @param Traversal $traversal 
	 * @access public
	 * @return void
	 */
	function handle(Traversal $traversal);
}
