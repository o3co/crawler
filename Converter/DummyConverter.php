<?php
namespace O3Com\Crawler\Converter;

class DummyConverter implements Converter 
{
	public function convert($value)
	{
		return $value;
	}
}

