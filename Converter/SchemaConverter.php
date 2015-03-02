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

class SchemaConverter 
{
	private $converters = array();

	public function __construct(array $converters = array())
	{
		foreach($converters as $key => $converter) {
			$this->setConverter($key, $converter);
		}
	}

	public function convert($key, $value) 
	{
		if(isset($this->converters[$key])) {
			if(is_array($value)) {
				foreach($value as $k => $v) {
					$cleaned[$k] = $this->getConverter($key)->convert($v);
				}
			} else {
				$cleaned = $this->getConverter($key)->convert($value);
			}
		}
		return $cleaned;
	}
	
	public function convertAll(array $values)
	{
		foreach($values as $key => $value) {
			if(isset($this->converters[$key])) {
				$values[$key] = $this->convert($key, $value);
			}
		}
		return $values;
	}

	public function setConverter($key, Converter $converter)
	{
		$this->converters[$key] = $converter;

		return $this;
	}

	public function getConverter($key)
	{
		return $this->converters[$key];
	}
}

