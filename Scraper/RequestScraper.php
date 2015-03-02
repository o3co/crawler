<?php
namespace O3Com\Crawler\Scraper;

use O3Com\Crawler\Traverser\Traversal;

/**
 * RequestScraper 
 * 
 * @uses Scraper
 * @abstract
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
abstract class RequestScraper extends AbstractScraper
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
			$this->scrapeRequest($traversal->getCurrentPage()->getResponse())
		);
	}

	/**
	 * scrapeRequest 
	 * 
	 * @param mixed $request 
	 * @abstract
	 * @access public
	 * @return void
	 */
	abstract public function scrapeRequest($request);
}

