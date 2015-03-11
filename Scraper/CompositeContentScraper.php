<?php
namespace O3Co\Crawler\Scraper;

use O3Co\Crawler\Scraper;
use Symfony\Component\DomCrawler\Crawler;
/**
 * CompositeContentScraper 
 * 
 * @uses ContentScraper
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class CompositeContentScraper extends ContentScraper
{
	/**
	 * scrapers 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $scrapers;

	/**
	 * __construct 
	 * 
	 * @param array $scrapers 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public function __construct(array $scrapers = array(), array $options = array())
	{
		$this->scrapers = array();
		foreach($scrapers as $key => $scraper) {
			$this->setScraper($key, $scraper);		
		}

		parent::__construct(null, $options);
	}

	/**
	 * scrapeContent 
	 * 
	 * @param Crawler $crawler 
	 * @access public
	 * @return void
	 */
	public function scrapeContent(Crawler $crawler)
	{
		$rootSelector = $this->getRootSelector();

		if($rootSelector) {
			if($this->getOption('use_multi')) {	
				$response = $crawler->filter($rootSelector)->each(function($v) {
					return $this->scrapeChildContent($v);
				});
			} else {
				// execute only for first
				$response = $this->scrapeChildContent($crawler->filter($rootSelector)->first());
			}
		} else {
			$response = $this->scrapeChildContent($crawler);
		}

		if(!$this->getOption('group_by_root', true)) {
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

		return $response;
	}

	public function scrapeChildContent(Crawler $crawler)
	{
		$response = array();
		// scrape each 
		foreach($this->getScrapers() as $key => $scraper) {
			try {
				$response[$key] = $scraper->scrapeContent($crawler);
			} catch(\Exception $ex) {
				throw new \RuntimeException(sprintf('Failed to scrape for "%s"', $key), 0, $ex);
			}
		}

		if(!$this->getOption('group_by_field', true)) {
			// group by index 
			$temp = array();

			// prepare temporary array for all index of the values.
			foreach($response as $field => $values) {
				if(is_array($values)) {
					foreach($values as $index => $v) {
						if(!isset($temp[$index])) {
							// create 
							$temp[$index] = array();
						}
					}
				}
			}

			// copy the values
			foreach($response as $field => $values) {
				if(is_array($values)) {
					foreach($values as $index => $value) {
						$temp[$index][$field] = $value;
					}
				} else {
					// copy into all index group 
					foreach($temp as $k => $v) {
						$temp[$k][$field] = $values;
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

    /**
     * getScrapers 
     * 
     * @access public
     * @return void
     */
    public function getScrapers()
    {
        return $this->scrapers;
    }
    
    /**
     * setScrapers 
     * 
     * @param array $scrapers 
     * @access public
     * @return void
     */
    public function setScrapers(array $scrapers)
    {
        $this->scrapers = array();
		foreach($scrapers as $key => $scraper) {
			$this->setScraper($key, $scraper);		
		}
        return $this;
    }

	/**
	 * setScraper 
	 * 
	 * @param mixed $key 
	 * @param Scraper $scraper 
	 * @access public
	 * @return void
	 */
	public function setScraper($key, Scraper $scraper)
	{
		$this->scrapers[$key] = $scraper;
		return $this;
	}
    
    public function getRootSelector()
    {
        return $this->getOption('root');
    }

	public function filterResponse($value)
	{
		if($this->hasConverter()) {
			$value = $this->getConverter()->convert($value);
		}
		return $value;
	}
}

