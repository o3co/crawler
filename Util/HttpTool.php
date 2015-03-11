<?php
namespace O3Co\Crawler\Util;

/**
 * HttpTool 
 * 
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class HttpTool
{
	/**
	 * parseHeaderParts 
	 * 
	 * @param mixed $header 
	 * @static
	 * @access public
	 * @return void
	 */
	static public function parseHeaderParts($header)
	{
		$values = array();
		$kvs = str_getcsv($header, ';');
		foreach($kvs as $kv) {
			$pair = str_getcsv($kv, '=');
			if(1 == count($pair)) {
				$values['value'] = $pair[0];
			} else if(2 == count($pair)) {
				$values[$pair[0]] = $pair[1];
			}
		}
		return $values;
	}
}
