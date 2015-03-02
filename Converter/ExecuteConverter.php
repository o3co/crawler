<?php
namespace O3Com\Crawler\Converter;

/**
 * ExecuteConverter 
 * 
 * @uses Converter
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class ExecuteConverter extends AbstractConverter
{
	/**
	 * closure 
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $closure;

	/**
	 * __construct 
	 * 
	 * @param \Closure $closure 
	 * @access public
	 * @return void
	 */
	public function __construct(\Closure $closure)
	{
		$this->closure = $closure;
	}

	/**
	 * doConvert 
	 * 
	 * @param mixed $value 
	 * @access protected
	 * @return void
	 */
	protected function doConvert($value)
	{
		if(!$this->closure) {
			throw new \RuntimeException('ExecuteConverter requires $closure is as a Closure.');
		}

		$closure = $this->closure;

		return $closure($value);
	}
}

