<?php
namespace O3Co\Crawler\Converter;

class SplitConverter extends StringConverter
{
	static public function createConverterWithArgs(array $args = array())
	{
		list($pattern, $valueOnInvalid, $skipOnInvalid) = static::pullArgsFromArray($args);
		return new static($pattern, $valueOnInvalid, $skipOnInvalid);
	}

	static public function pullArgsFromArray(array $args)
	{
		list($valueOnInvalid, $skipOnInvalid) = parent::pullArgsFromArray($args);

		if(!isset($args['pattern'])) {
			throw new \InvalidArgumentException('SplitConverter required "pattern" attribute.');
		}

		return array($args['pattern'], $valueOnInvalid, $skipOnInvalid);
	}

	public function __construct($pattern, $valueOnInvalid = null, $skipOnInvalid = false)
	{
		parent::__construct($valueOnInvalid, $skipOnInvalid);
		$this->pattern = $pattern;
	}

	protected function doConvert($value)
	{
		$splited = preg_split($this->pattern, $value);


		if(count($splited) <= 1) {
			// not splited.
			if($this->skipOnInvalid) {
				return $value;
			}
			return $this->valueOnInvalid;
		}

		return $splited;
	}
}

