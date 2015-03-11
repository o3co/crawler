<?php
namespace O3Co\Crawler\Scraper;

use O3Co\Crawler\Scraper;
use O3Co\Crawler\Converter;

/**
 * AbstractScraper 
 * 
 * @uses Scraper
 * @abstract
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
abstract class AbstractScraper implements Scraper
{
	const USE_MULTI_RESPONSE = 'use_multi';

	/**
	 * converter 
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $converter;

	/**
	 * options 
	 * 
	 * @var array
	 * @access protected
	 */
	protected $options = array();

	/**
	 * __construct 
	 * 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public  function __construct(Converter $converter = null, array $options = array())
	{
		$this->converter = $converter;
		$this->options   = $options;
	}

	/**
	 * filterResponse 
	 * 
	 * @param mixed $value 
	 * @access public
	 * @return void
	 */
	public function filterResponse($value)
	{
		if(isset($this->options[self::USE_MULTI_RESPONSE])) {
			$value = (array)$value;
		} else if(is_array($value)) {
			$value = reset($value);
		}

		if($this->hasConverter()) {
			$value = $this->getConverter()->convert($value);
		}
		return $value;
	}
    
    /**
     * getOptions 
     * 
     * @access public
     * @return void
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * setOptions 
     * 
     * @param mixed $options 
     * @access public
     * @return void
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

	/**
	 * getOption 
	 * 
	 * @param mixed $key 
	 * @param mixed $default 
	 * @access public
	 * @return void
	 */
	public function getOption($key, $default = null)
	{
		return isset($this->options[$key])
			? $this->options[$key]
			: $default;
	}
	
	/**
	 * hasOption 
	 * 
	 * @param mixed $key 
	 * @access public
	 * @return void
	 */
	public function hasOption($key)
	{
		return isset($this->options[$key]);
	}

	/**
	 * setOption 
	 * 
	 * @param mixed $key 
	 * @param mixed $value 
	 * @access public
	 * @return void
	 */
	public function setOption($key, $value)
	{
		$this->options[$key] = $value;
	}
    
	public function isMultiResponse()
	{
		return isset($this->options[self::USE_MULTI_RESPONSE]);
	}

    /**
     * getConverter 
     * 
     * @access public
     * @return void
     */
    public function getConverter()
    {
        return $this->converter;
    }
    
    /**
     * setConverter 
     * 
     * @param Converter $converter 
     * @access public
     * @return void
     */
    public function setConverter(Converter $converter)
    {
        $this->converter = $converter;
        return $this;
    }

	/**
	 * hasConverter 
	 * 
	 * @access public
	 * @return void
	 */
	public function hasConverter()
	{
		return (bool)$this->converter;
	}
}

