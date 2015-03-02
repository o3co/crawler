<?php
namespace O3Com\Crawler\Converter;

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

