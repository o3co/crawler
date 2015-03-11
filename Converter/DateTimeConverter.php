<?php
namespace O3Co\Crawler\Converter;

abstract class DateTimeConverter extends AbstractConverter 
{
	protected function isValid($value)
	{
		return ($value instanceof \DateTime);
	}
}

