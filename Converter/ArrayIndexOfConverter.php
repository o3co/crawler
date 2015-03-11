<?php
namespace O3Co\Crawler\Converter;

class ArrayIndexOfConverter extends ArrayConverter 
{
	static public function createConverterWithArgs(array $args = array())
	{
		list($index, $valueOnInvalid, $skipOnInvalid) = static::pullArgsFromArray($args);
		return new static($index, $valueOnInvalid, $skipOnInvalid);
	}

	static public function pullArgsFromArray(array $args)
	{
		list($valueOnInvalid, $skipOnInvalid) = parent::pullArgsFromArray($args);

		if(!isset($args['index'])) {
			throw new \InvalidArgumentException('ArrayIndexOfConverter required "index" attribute.');
		}

		return array($args['index'], $valueOnInvalid, $skipOnInvalid);
	}

	private $index;

	public function __construct($index, $valueOnInvalid, $skipOnInvalid)
	{
		parent::__construct($valueOnInvalid, $skipOnInvalid);

		$this->index = $index;
	}

	protected function doConvert($value)
	{
		if(count($value) > $this->index) {
			return $value[$this->index];
		}

		return $this->valueOnInvalid;
	}
}

