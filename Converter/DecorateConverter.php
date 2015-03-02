<?php
/**
 * ${ FILENAME }
 * 
 * @copyright (c) Itandi, Inc. <http://itandi.co.jp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 */
namespace O3Com\Crawler\Converter;

class DecorateConverter extends StringConverter
{
	static public function createConverterWithArgs(array $args = array())
	{
		list($format, $valueOnInvalid, $skipOnInvalid) = self::pullArgsFromArray($args);
		return new static($format, $valueOnInvalid, $skipOnInvalid);
	}

	static public function pullArgsFromArray(array $args)
	{
		list($valueOnInvalid, $skipOnInvalid) = parent::pullArgsFromArray($args);

		if(!isset($args['format'])) {
			throw new \InvalidArgumentException('DecorateConverter required "format" attribute.');
		}
		return array($args['format'], $valueOnInvalid, $skipOnInvalid);
	}

	private $format;

	public function __construct($format, $valueOnInvalid = null, $skipOnInvalid = false)
	{
		parent::__construct($valueOnInvalid, $skipOnInvalid);
		$this->format = $format;
	}

	protected function doConvert($value)
	{
		return strtr($this->format, array('%VALUE%' => $value));
	}
    
    public function getFormat()
    {
        return $this->format;
    }
    
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }
}

