<?php
namespace O3Com\Crawler\Scraper;

use Symfony\Component\DomCrawler\Crawler;

/**
 * HtmlTextContentScraper 
 * 
 * @uses HtmlDomScraper
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class HtmlTextContentScraper extends ContentScraper 
{
	public function scrapeContent(Crawler $crawler)
	{
		// Get DOM Object
		$dom = parent::doScrape($crawler);

		// Convert DOM Object to String
		return mb_convert_encoding($dom->saveHtml(), $dom->encoding, 'HTML-ENTITIES');
	}
}

