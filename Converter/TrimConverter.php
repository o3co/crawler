<?php
namespace O3Com\Crawler\Converter;

class TrimConverter extends AbstractConverter  
{
	const TRIM_BOTH  = 0;
	const TRIM_LEFT  = 1;
	const TRIM_RIGHT = 2;

	const DEFAULT_TRIM_CHARS = '\x{3000}\s\t\n\r\0\x0B';

	static public function createConverterWithArgs(array $args = array())
	{
		list($type, $chars, $valueOnInvalid, $skipOnInvalid) = static::pullArgsFromArray($args);
		return new static($type, $chars, $valueOnInvalid, $skipOnInvalid);
	}

	static public function pullArgsFromArray(array $args)
	{
		list($valueOnInvalid, $skipOnInvalid) = parent::pullArgsFromArray($args);

		if(!isset($args['type'])) {
			$args['type'] = self::TRIM_BOTH;
		}

		if(!isset($args['chars'])) {
			$args['chars'] = self::DEFAULT_TRIM_CHARS;
		}

		return array($args['type'], $args['chars'], $valueOnInvalid, $skipOnInvalid);
	}

	private $type;

	private $trimChar;

	public function __construct($type = self::TRIM_BOTH, $trimChar = self::DEFAULT_TRIM_CHARS)
	{
		$this->type = $type;
		$this->trimChar = $trimChar;
	}

	protected function doConvert($value)
	{
		switch($this->getType()) {
		case self::TRIM_LEFT:
			return preg_replace('/^[' . $this->trimChar. ']+/u', '', $value);
			break;
		case self::TRIM_RIGHT:
			return preg_replace('/[' . $this->trimChar. ']+$/u', '', $value);
			break;
		default:
			$value = preg_replace('/(^[' . $this->trimChar. ']+)|([' . $this->trimChar. ']+$)/us', '', $value);

			return $value;
			break;
		}
	}
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    
    public function getTrimChar()
    {
        return $this->trimChar;
    }
    
    public function setTrimChar($trimChar)
    {
        $this->trimChar = $trimChar;
        return $this;
    }
}

