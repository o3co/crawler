<?php
namespace O3Com\Crawler\Scraper;

use O3Com\Crawler\Scraper;
use O3Com\Crawler\Traverser\Traversal;
use Symfony\Component\DomCrawler\Crawler;

/**
 * ContentScraper 
 * 
 * @uses Scraper
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
abstract class ContentScraper extends AbstractScraper
{
	/**
	 * scrape 
	 * 
	 * @param Traversal $traversal 
	 * @access public
	 * @return void
	 */
	public function scrape(Traversal $traversal)
	{
		return $this->filterResponse(
			$this->scrapeContent($traversal->getCurrentPage()->getCrawler())
		);
	}

	/**
	 * scrapeContent 
	 * 
	 * @abstract
	 * @access protected
	 * @return void
	 */
	abstract public function scrapeContent(Crawler $crawler);
}
