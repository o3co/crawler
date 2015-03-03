<?php
namespace O3Com\Crawler\Traverser;

interface Node
{
	/**
	 * getCrawler 
	 * 
	 * @param Traversal $traversal 
	 * @access public
	 * @return void
	 */
	function getCrawler(Traversal $traversal);
}
