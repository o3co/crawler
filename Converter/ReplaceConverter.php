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
namespace O3Co\Crawler\Converter;

/**
 * ReplaceConverter 
 * 
 * @uses AbstractConverter
 * @package { PACKAGE }
 * @copyright { COPYRIGHT } (c) { COMPANY }
 * @author Yoshi <yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class ReplaceConverter extends AbstractConverter
{
	const TYPE_STR_REPLACE  = 'str';
	const TYPE_PREG_REPLACE = 'preg';

	static public function createConverterWithArgs(array $args = array())
	{
		list($patterns, $matchType, $valueOnInvalid, $skipOnInvalid) = self::pullArgsFromArray($args);
		return new static($patterns, $matchType, $valueOnInvalid, $skipOnInvalid);
	}

	static public function pullArgsFromArray(array $args)
	{
		list($valueOnInvalid, $skipOnInvalid) = parent::pullArgsFromArray($args);

		if(!isset($args['patterns'])) {
			throw new \InvalidArgumentException('ReplaceConverter required "patterns" attribute.');
		}

		if(!isset($args['match_type'])) {
			$args['match_type'] = self::TYPE_STR_REPLACE;
		}

		return array($args['patterns'], $args['match_type'], $valueOnInvalid, $skipOnInvalid);
	}

	private $patterns;

	private $type;

	public function __construct(array $patterns = array(), $type = self::TYPE_STR_REPLACE)
	{
		$this->patterns = $patterns;
		$this->type = $type;
	}

	protected function doConvert($value)
	{
		switch($this->type) {
		case self::TYPE_PREG_REPLACE:
			$value = preg_replace(array_keys($this->patterns), array_values($this->patterns), $value);
			break;
		case self::TYPE_STR_REPLACE:
		default:
			$value = str_replace(array_keys($this->patterns), array_values($this->patterns), $value);
			break;
		}

		return $value;
	}
    
    public function getPatterns()
    {
        return $this->patterns;
    }
    
    public function setPatterns($patterns)
    {
        $this->patterns = $patterns;
        return $this;
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
}

