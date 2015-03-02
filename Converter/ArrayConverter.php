<?php
namespace O3Com\Crawler\Converter;

abstract class ArrayConverter extends AbstractConverter 
{
	protected function isValid($value)
	{
		return !is_null($value) && is_array($value);
	}
}

