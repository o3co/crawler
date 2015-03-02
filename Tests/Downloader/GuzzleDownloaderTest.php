<?php
namespace O3Com\Crawler\Tests\Downloader;

use O3Com\Crawler\Downloader\GuzzleDownloader;

class GuzzleDownloaderTest extends \PHPUnit_Framework_TestCase 
{
	private $client;

	public function setUp()
	{
		$this->client = new \GuzzleHttp\Client();
	}

	public function testDownload()
	{
		$downloader = new GuzzleDownloader($this->getClient());

		$files = $downloader->download('https://www.google.co.jp/images/srpr/logo11w.png');

		$this->assertCount(1, $files);
		$this->assertInstanceof('O3Com\Crawler\File\DownloadedFile', $files[0]);
		$this->assertEquals('logo11w.png', $files[0]->getOriginalName());
		$this->assertEquals('png', $files[0]->getExtension());
	}

/*
	public function testDownloadMulti()
	{
		$downloader = new GuzzleDownloader($this->getClient());

		$files = $downloader->download(array(
				'https://www.google.co.jp/images/srpr/logo11w.png',
				'https://www.google.co.jp/images/srpr/logo11w.png',
				'https://www.google.co.jp/images/srpr/logo11w.png',
			);

		$this->assertCount(1, $files);
	}
*/   
    public function getClient()
    {
        return $this->client;
	}
}

