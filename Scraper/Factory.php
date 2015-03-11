<?php
namespace O3Co\Crawler\Scraper;

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
	function createScraper($type, array $args = array());
}

