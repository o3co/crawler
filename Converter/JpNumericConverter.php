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

class JpNumericConverter extends AbstractConverter 
{
	static private $numericChars = array(
		'０' => 0, '〇' => 0, '零' => 0,
		'１' => 1, '一' => 1, '壱' => 1,
		'２' => 2, '二' => 2, '弐' => 2,
		'３' => 3, '三' => 3, '参' => 3,
		'４' => 4, '四' => 4,
		'５' => 5, '五' => 5,
		'６' => 6, '六' => 6,
		'７' => 7, '七' => 7,
		'８' => 8, '八' => 8,
		'９' => 9, '九' => 9
	);

	static private $positionChars = array(
		'十'  => 10,
		'百'  => 100,
		'千'  => 1000,
		'万'  => 10000,
		'億'  => 100000000,
	);

	static private $decimalPointChars = array(
		'.' => '.',
		'．' => '.',
		',' => '',
		'，' => '',
	);

	protected function doConvert($value)
	{
		$value = (string)$value;
		$total = 0;
		$sub_total = '';
		$posRadix = $mainRadix = 1;

		$len = mb_strlen($value);

		for($i = $len - 1; $i >= 0; $i--) {
			$char = mb_substr($value, $i, 1);

			if(!$this->isValidChar($char)) {
				// skip
				continue;
			} else if($this->isPositionalChar($char)) {
				$pos = $this->convertCharToNum($char);
				if($pos < 10000) {
					$posRadix = $mainRadix * $pos;
				} else {
					$posRadix = $mainRadix = $pos;
				}
				
				// if left most or positional char is followed, then add to total 
				if((0 == $i) || $this->isPositionalChar(mb_substr($value, $i - 1, 1))) {
					$total += $posRadix;
				}
				continue;
			} 

			$sub_total = (string)$this->convertCharToNum($char) . $sub_total;
			if((0 == $i) || !$this->isNumericChar(mb_substr($value, $i - 1, 1))) {
				$total += ((float)$sub_total * $posRadix);
				$sub_total = '';
			}
			// Move to next position
			// $posRadix *= 10;
		}
		return $total;
	}

	protected function isValidChar($char)
	{
		return (is_numeric($char) || array_key_exists($char, self::$numericChars) || array_key_exists($char, self::$positionChars) || array_key_exists($char, self::$decimalPointChars));
	}

	protected function isPositionalChar($char)
	{
		return array_key_exists($char, self::$positionChars);
	}

	protected function isNumericChar($char)
	{
		return (is_numeric($char) || array_key_exists($char, self::$numericChars) || array_key_exists($char, self::$decimalPointChars));
	}

	protected function convertCharToNum($char)
	{
		if(array_key_exists($char, self::$numericChars)) {
			return self::$numericChars[$char];
		} else if(array_key_exists($char, self::$positionChars)) {
			return self::$positionChars[$char];
		} else if(is_numeric($char)) {
			return (int)$char;
		} else if (array_key_exists($char, self::$decimalPointChars)) {
			return self::$decimalPointChars[$char];
		}
		return 0;
	}
}

