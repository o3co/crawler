<?php
namespace O3Com\Crawler\Traverser\Handler;

use O3Com\Crawler\Traverser\Traversal;
use O3Com\Crawler\Page;
use O3Com\Crawler\Scraper;
use O3Com\Crawler\Event\ScrapeEvents,
	O3Com\Crawler\Event\ScrapeEvent;

/**
 * ScrapeHandler 
 * 
 * @uses AbstractHandler
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class ScrapeHandler extends AbstractHandler
{
	private $domain;

	private $scraper;

	public function __construct($scraper, $domain)
	{
		$this->scraper = $scraper;
		$this->domain = $domain;
	}

	protected function doHandle(Traversal $traversal)
	{
		$scraper = $this->getScraper();
		if(is_callable($scraper)) {
			$scraper = $scraper($traversal);
		}

		if(!$scraper instanceof Scraper) {
			throw new \RuntimeException('Scraper has to be a Scraper object or callable which return a scraper');
		}
		$traversal->dispatch(ScrapeEvents::onPreScrape, new ScrapeEvent($scraper, $traversal, array('domain' => $this->getDomain())));

		$content = $scraper->scrape($traversal);

		$traversal->dispatch(ScrapeEvents::onPostScrape, new ScrapeEvent($scraper, $traversal, array('content' => $content, 'domain' => $this->getDomain())));

		$traversal->getCurrentPage()->setContent($content, $this->getDomain());
	}
    
    public function getDomain()
    {
        return $this->domain;
    }
    
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
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
