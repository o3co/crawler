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
 * Factory 
 * 
 * @package { PACKAGE }
 * @copyright { COPYRIGHT } (c) { COMPANY }
 * @author Yoshi <yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
interface Factory 
{
	function createConverter($type, array $args = array());
}

