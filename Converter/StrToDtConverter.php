<?php
namespace O3Co\Crawler\Converter;

class StrToDtConverter extends StringConverter 
{
	static public function createConverterWithArgs(array $args = array())
	{
		return new self($args['format']);
	}

	private $format;

	public function __construct($format = 'Y-m-d H:i:s', $valueOnInvalid = null, $skipOnInvalid = false)
	{
		$this->format = $format;
	}

	protected function doConvert($value)
	{
		$dt = \DateTime::createFromFormat($this->format, $value);

		if(!$dt) {
			if($this->skipOnInvalid) {
				return $valud;
			} else {
				return $this->valueOnInvalid;
			}
		}
		return $dt;
	}
}

