<?php
namespace O3Co\Crawler\Converter;

class JpDirectionalFilterConverter extends StringConverter 
{
	protected function doConvert($value)
	{
		$matches = array();
		if(preg_match('/([東西南北]+)/u', $value, $matches)) {
			return trim($matches[1]);
		}
		return $this->valueOnInvalid;
	}
}

