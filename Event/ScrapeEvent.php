<?php
namespace O3Co\Crawler\Event;

use O3Co\Crawler\Traverser\Traversal;
use O3Co\Crawler\Scraper;

/**
 * ScrapeEvent 
 * 
 * @uses Event
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class ScrapeEvent extends TraversalEvent 
{
	private $scraper;

	public function __construct(Scraper $scraper, Traversal $traversal, array $args = array())
	{
		parent::__construct($traversal, $args);
		$this->scraper = $scraper;
	}
    
    
    public function getScraper()
    {
        return $this->scraper;
    }
    
    public function setScraper($scraper)
    {
        $this->scraper = $scraper;
        return $this;
    }
}

