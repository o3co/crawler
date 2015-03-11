<?php
namespace O3Co\Crawler\Converter;

class DummyConverter implements Converter 
{
	public function convert($value)
	{
		return $value;
	}
}

