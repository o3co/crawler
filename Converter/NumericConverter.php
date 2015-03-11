<?php
namespace O3Co\Crawler\Converter;

/**
 * NumericConverter 
 * 
 * @uses CompositeConverter
 * @package { PACKAGE }
 * @copyright { COPYRIGHT } (c) { COMPANY }
 * @author Yoshi <yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class NumericConverter extends StringConverter 
{
	protected function doConvert($value)
	{
		$replaced = preg_replace('/[^0-9\.\+\-]/', '', $value);

		if($replaced && preg_match('/^(\-|\+){0,1}([0-9]+)(,[0-9][0-9][0-9])*([.][0-9]){0,1}([0-9]*)$/', $replaced)) {
			return $replaced;
		}

		if($this->skipOnInvalid) {
			return $value;
		} else {
			return $this->valueOnInvalid;
		}
	}
}

