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

/**
 * ReplaceConverter 
 * 
 * @uses AbstractConverter
 * @package { PACKAGE }
 * @copyright { COPYRIGHT } (c) { COMPANY }
 * @author Yoshi Aoki <yoshi@44services.jp> 
 * @license { LICENSE }
 */
class ImplodeConverter extends AbstractConverter 
{
	static public function createConverterWithArgs(array $args = array())
	{
		list($glue, $valueOnInvalid, $skipOnInvalid) = self::pullArgsFromArray($args);
		return new static($glue, $valueOnInvalid, $skipOnInvalid);
	}

	static public function pullArgsFromArray(array $args)
	{
		list($valueOnInvalid, $skipOnInvalid) = parent::pullArgsFromArray($args);

		if(!isset($args['glue'])) {
			$args['glue'] = '';
		}

		return array($args['glue'], $valueOnInvalid, $skipOnInvalid);
	}

	private $glue;

	public function __construct($glue = '', $valueOnInvalid = null, $skipOnInvalid = false)
	{
		parent::__construct($valueOnInvalid, $skipOnInvalid);

		$this->glue = $glue;
	}

	protected function doConvert($value)
	{
		$value = implode($this->glue, (array)$value);

		return $value;
  }
}

