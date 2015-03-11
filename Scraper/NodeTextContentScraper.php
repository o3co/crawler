<?php
namespace O3Co\Crawler\Scraper;

use Symfony\Component\DomCrawler\Crawler;

/**
 * NodeTextContentScraper 
 * 
 * @uses NodeContentScraper
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class NodeTextContentScraper extends NodeContentScraper
{
	/**
	 * doScrape 
	 * 
	 * @param Crawler $node 
	 * @access protected
	 * @return void
	 */
	protected function doScrape(Crawler $node)
	{
		return $node->text();
	}
}
