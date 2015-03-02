<?php
namespace O3Com\Crawler\Converter;

abstract class StringConverter extends AbstractConverter 
{
	protected function isValid($value)
	{
		return !is_null($value) && is_string($value);
	}
}

