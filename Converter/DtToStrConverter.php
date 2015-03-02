<?php
namespace O3Com\Crawler\Converter;

class DtToStrConverter extends DateTimeConverter
{
	static public function createConverterWithArgs(array $args = array())
	{
		return new self($args['format']);
	}

	private $format;

	public function __construct($format = 'Y-m-d H:i:s')
	{
		$this->format = $format;
	}

	protected function doConvert($value)
	{
		return $value->format($this->format);
	}
}

