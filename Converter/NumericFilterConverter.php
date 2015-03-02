<?php
namespace O3Com\Crawler\Converter;

/**
 * NumericFilterConverter 
 *   Filter non-numeric chars  
 * @uses AbstractConverter
 * @package { PACKAGE }
 * @copyright { COPYRIGHT } (c) { COMPANY }
 * @author Yoshi Aoki <yoshi@44services.jp> 
 * @license { LICENSE }
 */
class NumericFilterConverter extends 
{
	protected function doConvert($value)
	{
		$numeric = '';
		$len = strlen($value);

		$value = preg_replace('/![0-9\.\+\-]/', '', $value);

		return $value;
	}
}

