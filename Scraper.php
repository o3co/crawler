<?php
namespace O3Co\Crawler;

use O3Co\Crawler\Traverser\Traversal;

/**
 * Scraper 
 * 
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
interface Scraper
{
	/**
	 * scrape 
	 * 
	 * @param Traversal $traversal 
	 * @access public
	 * @return void
	 */
	function scrape(Traversal $traversal);
}

