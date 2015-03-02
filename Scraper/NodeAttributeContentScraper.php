<?php
namespace O3Com\Crawler\Scraper;

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
class NodeAttributeContentScraper extends NodeContentScraper
{
	/**
	 * attrKey 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $attrKey;

	/**
	 * __construct 
	 * 
	 * @param mixed $selector 
	 * @param string $attr 
	 * @param mixed $converter 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public function __construct($selector, $attr = 'value', $converter = null, array $options = array())
	{
		parent::__construct($selector, $converter, $options);

		$this->attrKey = $attr;
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
		return $node->attr($this->getAttrKey());
	}
    
    /**
     * getAttrKey 
     * 
     * @access public
     * @return void
     */
    public function getAttrKey()
    {
        return $this->attrKey;
    }
    
    /**
     * setAttrKey 
     * 
     * @param mixed $attrKey 
     * @access public
     * @return void
     */
    public function setAttrKey($attrKey)
    {
        $this->attrKey = $attrKey;
        return $this;
    }
}

