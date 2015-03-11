<?php
/**
 * ${ FILENAME }
 * 
 * @copyright (c) Itandi, Inc. <http://itandi.co.jp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 */
namespace O3Co\Crawler\Converter;

use O3Co\Crawler\Converter;

/**
 * CompositeConverter 
 * 
 * @uses Converter
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class CompositeConverter implements Converter
{
	/**
	 * createConverterWithArgs 
	 * 
	 * @param array $args 
	 * @static
	 * @access public
	 * @return void
	 */
	static public function createConverterWithArgs(array $args = array())
	{
		return new static();
	}

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
		foreach($converters as $converter) {
			$this->addConverter($converter);
		}
	}

	/**
	 * convert 
	 * 
	 * @param mixed $value 
	 * @access public
	 * @return void
	 */
	public function convert($value)
	{
		foreach($this->converters as $converter) {
			$value = $converter->convert($value);
		}

		return $value;
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
        $this->converters = $converters;
        return $this;
    }

	/**
	 * addConverter 
	 * 
	 * @param Converter $converter 
	 * @access public
	 * @return void
	 */
	public function addConverter(Converter $converter)
	{
		$this->converters[] = $converter;
		return $this;
	}
}

