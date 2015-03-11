<?php
namespace O3Co\Crawler\Scraper;

use Symfony\Component\DomCrawler\Crawler;
/**
 * NodeAttributeContentScraper 
 * 
 * @uses NodeContentScraper
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class NodeInputValueContentScraper extends NodeAttributeContentScraper 
{
	/**
	 * __construct 
	 * 
	 * @param mixed $selector 
	 * @param mixed $converter 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public function __construct($selector, $converter = null, array $options = array())
	{
		parent::__construct($selector, 'value', $converter, $options);
	}
}
