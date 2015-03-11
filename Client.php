<?php
namespace O3Co\Crawler;

use Goutte\Client as BaseClient;
use O3Co\Crawler\Downloader\GuzzleDownloader;

/**
 * Client 
 * 
 * @uses BaseClient
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class Client extends BaseClient 
{
	/**
	 * download 
	 * 
	 * @param mixed $paths 
	 * @access public
	 * @return void
	 */
	public function download($paths, $method = 'GET')
	{
		// Create GuzzleDownloader
		$downloader = new GuzzleDownloader($this->getClient());

		return $downloader->download($paths, $method);
	}
}

