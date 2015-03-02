<?php
namespace O3Com\Crawler\Scraper;

use O3Com\Crawler\Scraper;
use O3Com\Crawler\Traverser\Traversal;

/**
 * StaticValueScraper 
 * 
 * @uses Scraper
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class StaticValueScraper implements Scraper 
{
	/**
	 * value 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $value;

	/**
	 * __construct 
	 * 
	 * @param mixed $value 
	 * @access public
	 * @return void
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}

	/**
	 * scrape 
	 * 
	 * @param mixed $content 
	 * @access public
	 * @return void
	 */
	public function scrape(Traversal $traversal)
	{
		return $this->value;
	}
}

