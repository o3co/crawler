<?php
namespace O3Co\Crawler\Scraper;

use O3Co\Crawler\Scraper;
use O3Co\Crawler\Traverser\Traversal;

class CompositeScraper extends AbstractScraper
{
	private $scrapers;

	public function __construct(array $scrapers = array(), array $options = array()) 
	{
		foreach($scrapers as $key => $scraper) {
			$this->setScraper($key, $scraper);
		}
		parent::__construct(null, $options);
	}
	
	public function scrape(Traversal $traversal)
	{
		$response = array();
		foreach($this->getScrapers() as $key => $scraper){ 
			try {
				$response[$key] = $scraper->scrape($traversal);
			} catch(\Exception $ex) {
				throw new \RuntimeException(sprintf('Failed to scrape for "%s"', $key), 0, $ex);
			}
		}

		if($this->getOption('group_by_field')) {
			$temp = array();
			foreach($response as $idx => $values) {
				if(is_array($values)) {
					foreach($values as $k => $v) {
						if(!isset($temp[$k]))
							$temp[$k] = array();
						$temp[$k][$idx] = $v;
					}
				}
			}

			$response = $temp;
		}

		if($this->getOption('terminate_on_empty') && empty($response)) {
			throw new TerminateException('Empty Content');
		}

		return $response;
	}
    
    public function getScrapers()
    {
        return $this->scrapers;
    }
    
    public function setScrapers(array $scrapers)
    {
        $this->scrapers = array();
		foreach($scrapers as $key => $scraper) {
			$this->setScraper($key, $scraper);	
		}
        return $this;
    }
	
	public function getScraper($key)
	{
		return $this->scrapers[$key];
	}

	public function setScraper($key, Scraper $scraper)
	{
		$this->scrapers[$key] = $scraper;
		return $this;
	}
}
