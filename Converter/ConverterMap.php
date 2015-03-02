<?php
namespace O3Com\Crawler\Converter;

use O3Com\Crawler\Converter;

/**
 * ConverterMap 
 * 
 * @uses Converter
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class ConverterMap implements Converter  
{
	/**
	 * converters 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $converters;

	/**
	 * __construct 
	 * 
	 * @param array $converters 
	 * @access public
	 * @return void
	 */
	public function __construct(array $converters = array())
	{
		$this->converters = array();
		foreach($converters as $key => $converter) 
			$this->setConverter($key, $converter);
	}

	/**
	 * convert 
	 * 
	 * @param mixed $values 
	 * @access public
	 * @return void
	 */
	public function convert($values)
	{
		if(!is_array($values)) {
			throw new \InvalidArgumentException('ConverterMap only accept value as an Array');
		}

		foreach($values as $key => $value) {
			if($this->hasConverter($key)) {
				$values[$key] = $this->getConverter($key)->convert($value);
			}
		}

		return $values;
	}
    
    /**
     * getConverters 
     * 
     * @access public
     * @return void
     */
    public function getConverters()
    {
        return $this->converters;
    }
    
    /**
     * setConverters 
     * 
     * @param array $converters 
     * @access public
     * @return void
     */
    public function setConverters(array $converters)
    {
        $this->converters = array();
		foreach($converters as $key => $converter)
			$this->setConverter($converter);
        return $this;
    }

	/**
	 * setConverter 
	 * 
	 * @param mixed $key 
	 * @param Converter $converter 
	 * @access public
	 * @return void
	 */
	public function setConverter($key, Converter $converter)
	{
		$this->converters[$key] = $converter;
		return $this;
	}

	/**
	 * getConverter 
	 * 
	 * @param mixed $key 
	 * @access public
	 * @return void
	 */
	public function getConverter($key)
	{
		return $this->converters[$key];
	}

	public function hasConverter($key)
	{
		return isset($this->converters[$key]);
	}
}

