<?php
namespace O3Co\Crawler\Scraper;

use Symfony\Component\DomCrawler\Crawler;

/**
 * DomContentScraper 
 * 
 * @uses ContentScraper
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class DomContentScraper extends ContentScraper 
{
	/**
	 * scrapeContent 
	 *    Return dom object 
	 * @param Crawler $crawler 
	 * @access protected
	 * @return void
	 */
	public function scrapeContent(Crawler $crawler)
	{
		return $crawler->getNode(0)->ownerDocument;
	}
}

