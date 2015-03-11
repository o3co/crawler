<?php
namespace O3Co\Crawler\Converter;

class MatchFilterConverter extends AbstractConverter
{
	static public function createConverterWithArgs(array $args = array())
	{
		list($pattern, $value, $strict) = self::pullArgsFromArray($args);
		return new static($pattern, $value, $strict);
	}

	static public function pullArgsFromArray(array $args)
	{
		if(!isset($args['pattern'])) {
			throw new \InvalidArgumentException('MapConverter required "pattern" attribute.');
		}

		if(!isset($args['strict'])) {
			$args['strict'] = false;
		}

		if(!isset($args['value'])) {
			$args['value'] = null;
		}

		return array($args['pattern'], $args['value'], $args['strict']);
	}

	private $patterns;

	private $value;

	private $strict;

	public function __construct($patterns, $value = null, $isStrict = false)
	{
		$this->patterns = (array)$patterns;
		$this->value = $value;
		$this->strict = $isStrict;
	}

	protected function doConvert($value)
	{
		foreach($this->patterns as $pattern) {
			if($this->strict) {
				if($pattern === $value) {
					return $this->value;
				}
			} else {
				if($pattern == $value) {
					return $this->value;
				}
			}
		}

		return $value;
	}
}

