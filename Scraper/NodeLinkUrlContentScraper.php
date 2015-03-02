<?php
namespace O3Com\Crawler\Scraper;

use Symfony\Component\DomCrawler\Crawler;

/**
 * NodeLinkUrlContentScraper 
 * 
 * @uses NodeContentScraper
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class NodeLinkUrlContentScraper extends NodeContentScraper
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
		if($this->getOption('use_absolute_path')) {
			return $node->link()->getUri();
		}
		return $node->attr('href');
	}
}

