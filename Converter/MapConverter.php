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
 * MapConverter 
 * 
 * @uses AbstractConverter
 * @package { PACKAGE }
 * @copyright { COPYRIGHT } (c) { COMPANY }
 * @author Yoshi Aoki <yoshi@44services.jp> 
 * @license { LICENSE }
 */
class MapConverter extends AbstractConverter 
{
	static public function createConverterWithArgs(array $args = array())
	{
		list($map, $valueOnInvalid, $skipOnInvalid) = self::pullArgsFromArray($args);
		return new static($map, $valueOnInvalid, $skipOnInvalid);
	}

	static public function pullArgsFromArray(array $args)
	{
		list($valueOnInvalid, $skipOnInvalid) = parent::pullArgsFromArray($args);

		if(!isset($args['map'])) {
			throw new \InvalidArgumentException('MapConverter required "map" attribute.');
		}
		return array($args['map'], $valueOnInvalid, $skipOnInvalid);
	}


	private $maps;

	public function __construct(array $maps = array(), $valueOnInvalid = null, $skipOnInvalid = false)
	{
		parent::__construct($valueOnInvalid, $skipOnInvalid);
		$this->maps = $maps;
	}

	protected function doConvert($value)
	{
		$maps = $this->getMaps();
		if(array_key_exists($value, $maps)) {
			return $maps[$value];
		}
		
		if($this->skipOnInvalid) {
			return $value;
		}

		return $this->valueOnInvalid;
	}
    
    public function getMaps()
    {
		return $this->maps;
    }
    
    public function setMaps(array $maps)
    {
        $this->maps = $maps;
        return $this;
    }
}

