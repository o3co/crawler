<?php
namespace O3Com\Crawler\Converter;

/**
 * ExtractConverter 
 * 
 * @uses AbstractConverter
 * @package { PACKAGE }
 * @copyright { COPYRIGHT } (c) { COMPANY }
 * @author Yoshi Aoki <yoshi@44services.jp> 
 * @license { LICENSE }
 */
class PregExtractConverter extends AbstractConverter 
{
	static public function createConverterWithArgs(array $args = array())
	{
		list($patterns, $valueOnInvalid, $skipOnInvalid) = self::pullArgsFromArray($args);
		return new static($patterns, $valueOnInvalid, $skipOnInvalid);
	}

	static public function pullArgsFromArray(array $args)
	{
		list($valueOnInvalid, $skipOnInvalid) = parent::pullArgsFromArray($args);

		if(!isset($args['patterns'])) {
			throw new \InvalidArgumentException('Argument "patterns" are not given for PregExtractConverter');
		}

		return array($args['patterns'], $valueOnInvalid, $skipOnInvalid);
	}

	private $patterns;

	public function __construct(array $patterns = array(), $valueOnInvalid = null, $skipOnInvalid = false)
	{
		$this->patterns = $patterns;
		parent::__construct($valueOnInvalid, $skipOnInvalid);
	}

	public function doConvert($value)
	{
		foreach($this->patterns as $pattern) {
			//
			$matches = array();
			if(preg_match($pattern, $value, $matches)) {
				if(isset($matches['VALUE'])) {
					$value = $matches['VALUE'];
				} else if(isset($matches[1])) {
					$value = $matches[1];
				} else {
					$value = $matches[0];
				}

				return $value;
			}
		}

		if(!$this->skipOnInvalid) {
			return $this->valueOnInvalid;
		}

		return $value;
	}
}

