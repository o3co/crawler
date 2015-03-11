<?php
namespace O3Co\Crawler\Scraper;

use O3Co\Crawler\Scraper;
use O3Co\Crawler\Converter;
use O3Co\Crawler\Traverser\Traversal;

/**
 * RequestUriQueryScraper 
 * 
 * @uses RequestScraper
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class RequestUriQueryScraper extends RequestScraper
{
	/**
	 * queryKey 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $queryKey;

	/**
	 * __construct 
	 * 
	 * @param mixed $queryKey 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public function __construct($queryKey, Converter $converter = null, array $options = array())
	{
		$this->queryKey = $queryKey;
		parent::__construct($converter, $options);
	}

	/**
	 * scrapeRequest 
	 * 
	 * @param mixed $request 
	 * @access public
	 * @return void
	 */
	public function scrapeRequest($request)
	{
		$queries = $this->getQueriesFromRequest($request);

		$response = null;

		if(isset($queries[$this->queryKey])) {
			$response = $queries[$this->queryKey];
		} 

		return $response;
	}

	/**
	 * getQueriesFromRequest 
	 * 
	 * @param mixed $request 
	 * @access protected
	 * @return void
	 */
	protected function getQueriesFromRequest($request)
	{
		$uri = parse_url($request->getUri());

		$queries = array();
		if(isset($uri['query'])) {
			parse_str($uri['query'], $queries);
		}

		return $queries;
	}
}

