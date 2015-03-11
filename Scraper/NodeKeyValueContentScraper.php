<?php
namespace O3Co\Crawler\Scraper;

use Symfony\Component\DomCrawler\Crawler;
/**
 * NodeKeyValueContentScraper 
 *   Scrape Key-Value from the Table td.
 *   Use index odd as key, and index even as value.
 * 
 *   new NodeKeyValueContentScraper('table td')
 * 
 * @uses DomContentScraper
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class NodeKeyValueContentScraper extends NodeContentScraper 
{
	/**
	 * $option['key']
	 *   function($node, $index, &$keys);
	 *
	 *
	 */
	const OPTION_KEY_CLOSURE = 'key';

	const OPTION_VALUE_TYPE  = 'value_as';

	const VALUE_AS_NODE = 0;
	const VALUE_AS_HTML = 1;
	const VALUE_AS_TEXT = 2;

	public function scrapeContent(Crawler $crawler) 
	{
		return $this->doScrape($crawler->filter($this->getSelector()));
	}

	/**
	 * doScrape 
	 * 
	 * @param Crawler $node 
	 * @access protected
	 * @return void
	 */
	protected function doScrape(Crawler $node)
	{
		$values  = array();
		$keys    = array();

		$closure = $this->getOption(self::OPTION_KEY_CLOSURE, function($v, $i, &$keys) {
			if(($i + 1) % 2) {
				// odd as key.
				$keys[$i + 1] = $v->text();
				return false;
			} else {
				return $keys[$i];
			}
		});

		$node->each(function($v, $index) use (&$keys, &$values, $closure) {
			$key = $closure($v, $index, $keys);
			if(false !== $key) {
				$values[$key] = $this->getNodeValue($v);
			}

			return ;
		});

		return $values;
	}

	protected function getNodeValue(Crawler $node)
	{
		switch($this->getOption(self::OPTION_VALUE_TYPE, self::VALUE_AS_TEXT)) {
		case self::VALUE_AS_TEXT:
			return $node->text();
		case self::VALUE_AS_HTML:
			return $node->html();
		case self::VALUE_AS_NODE:
			return $node;
		default:
			throw new \InvalidArgumentException('Invalid "value_as" option');
		}
	}

	public function filterResponse($value)
	{
		if($this->hasConverter()) {
			$value = $this->getConverter()->convert($value);
		}
		return $value;
	}
}

