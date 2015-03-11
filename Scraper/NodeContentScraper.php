<?php
namespace O3Co\Crawler\Scraper;

use Symfony\Component\DomCrawler\Crawler;
use O3Co\Crawler\Converter;

/**
 * NodeContentScraper 
 * 
 * @uses ContentScraper
 * @abstract
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
abstract class NodeContentScraper extends ContentScraper 
{
	/**
	 * selector 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $selector;

	/**
	 * __construct 
	 * 
	 * @param mixed $selector 
	 * @param Converter $converter 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public function __construct($selector, Converter $converter = null, array $options = array())
	{
		$this->selector = $selector;
		parent::__construct($converter, $options);
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
		$filterCrawler = $crawler->filter($this->getSelector());

		if(!$this->isMultiResponse()) {
			$response = $this->doScrape($filterCrawler);
		} else {
			$response = $filterCrawler->each(function($node) {
				return $this->doScrape($node);
			});
		}

		return $response;
	}

	/**
	 * doScrape 
	 * 
	 * @param Crawler $node 
	 * @abstract
	 * @access protected
	 * @return void
	 */
	abstract protected function doScrape(Crawler $node);
    
    /**
     * getSelector 
     * 
     * @access public
     * @return void
     */
    public function getSelector()
    {
        return $this->selector;
    }
    
    /**
     * setSelector 
     * 
     * @param mixed $selector 
     * @access public
     * @return void
     */
    public function setSelector($selector)
    {
        $this->selector = $selector;
        return $this;
    }
}

