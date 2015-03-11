<?php
namespace O3Co\Crawler\Converter\Factory;

use O3Co\Crawler\Converter\Factory;
use Application\Core\Factory\AliasedClassFactory;


/**
 * TypedFactory 
 * 
 * @uses AliasedClassFactory
 * @uses Factory
 * @package { PACKAGE }
 * @copyright { COPYRIGHT } (c) { COMPANY }
 * @author Yoshi Aoki <yoshi@44services.jp> 
 * @license { LICENSE }
 */
class TypedFactory extends AliasedClassFactory implements Factory
{
	static public function createDefaultFactory()
	{
		return new static(array(
			'numeric'      => 'O3Co\Crawler\Converter\NumericConverter',
			'replace'      => 'O3Co\Crawler\Converter\ReplaceConverter', 
			'preg_extract' => 'O3Co\Crawler\Converter\PregExtractConverter', 
			'jp_numeric'       => 'O3Co\Crawler\Converter\JpNumericConverter', 
			'map'          => 'O3Co\Crawler\Converter\MapConverter', 
			'preg_map'          => 'O3Co\Crawler\Converter\PregMapConverter', 
			'decorate'     => 'O3Co\Crawler\Converter\DecorateConverter', 
			'trim'     => 'O3Co\Crawler\Converter\TrimConverter', 
			'str_to_dt'     => 'O3Co\Crawler\Converter\StrToDtConverter', 
			'dt_to_str'     => 'O3Co\Crawler\Converter\DtToStrConverter', 
			'jp_directional_filter'  => 'O3Co\Crawler\Converter\JpDirectionalFilterConverter', 
			'empty_filter'  => 'O3Co\Crawler\Converter\EmptyFilterConverter', 
			'index_of'      => 'O3Co\Crawler\Converter\ArrayIndexOfConverter', 
			'split'      => 'O3Co\Crawler\Converter\SplitConverter', 
			'implode'      => 'O3Co\Crawler\Converter\ImplodeConverter', 
			'match_filter'      => 'O3Co\Crawler\Converter\MatchFilterConverter', 
		));
	}

	private $logger;

	public function createConverter($type, array $args = array()) 
	{
		$converter = $this->createByAliasArgs($type, array($args));

		return $converter;
	}

	protected function constructInstance(\ReflectionClass $class, array $args)
	{
		return $class->getMethod('createConverterWithArgs')->invokeArgs(null, $args);
	}

	public function getTypes()
	{
		return array_keys($this->getClasses());
	}
}

