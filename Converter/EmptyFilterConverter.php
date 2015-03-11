<?php
namespace O3Co\Crawler\Converter;

class EmptyFilterConverter extends AbstractConverter
{
	protected function doConvert($value)
	{
		if(empty($value)) {
			return null;
		}
		return $value;
	}
}

