<?php
namespace O3Com\Crawler\Downloader;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Pool as GuzzlePool;
use GuzzleHttp\Message\Response as GuzzleResponse;

use O3Com\Crawler\File\DownloadedFile;
use O3Com\Crawler\Util\HttpTool;

class GuzzleDownloader  
{
	private $client;

	private $tmpDir;

	private $concurrentSize;

	public function __construct(GuzzleClient $client, $concurrentSize = 10, $tmpDir = '/tmp')
	{
		$this->client = $client;
		$this->tmpDir = $tmpDir;
		$this->concurrentSize = $concurrentSize;
	}

	public function download($paths, $method = 'GET') 
	{
		if(!is_array($paths)) {
			$paths = (array)$paths;
		}

		if(empty($paths)) {
			return array();
		}

		$client = $this->client;

		foreach($paths as $path) {
			if(!is_string($path)) {
				throw new \InvalidArgumentException('Downloader::download() only accept string or array of strings.');
			}
			$requests[] = $client->createRequest($method, $path);
		}
		
		$responses = GuzzlePool::batch($client, $requests, array('pool_size' => $this->getConcurrentSize()));

		$files = array();
		// Get only successful response
		foreach($responses->getSuccessful() as $response) {
			$files[] = $this->createFileFromResponse($response);
		}

		return $files;
	}

	protected function createFileFromResponse(GuzzleResponse $response)
	{
		$disposition = HttpTool::parseHeaderParts($response->getHeader('Content-Disposition'));
		$filename = isset($disposition['filename']) ? $disposition['filename'] : false;
		if(!$filename) {
			// Content-Disposition is not setted, thus try to use url to figure original filename.
			$path = $response->getEffectiveUrl();
			$filename = basename($path);
		}
		$size     = $response->getHeader('Content-Length');
		$contentType = HttpTool::parseHeaderParts($response->getHeader('Content-Type'));
		$mimeType = $contentType['value'];

		$path = $this->createTmpFile((string)$response->getBody());

		return new DownloadedFile($path, $response->getEffectiveUrl(), $filename, $mimeType, $size);
	}

	public function createTmpFile($contents)
	{
		$path = realpath($this->tmpDir);
		if(!$path) {
			throw new \RuntimeException(sprintf('TemoraryDir "%s" is not exists.', $this->tmpDir));
		}

		$path = $path . '/dl_' .uniqid();

		if(false === file_put_contents($path, $contents)) {
			throw new \RuntimeException('Faild to create temporary file.');	
		}

		return $path;
	}
    
    public function getClient()
    {
		if(!$this->client) {
			$this->client = new GuzzleClient();
		}
        return $this->client;
    }
    
    public function setClient(GuzzleClient $client)
    {
        $this->client = $client;
        return $this;
    }
    
    public function getTemporaryDir()
    {
        return $this->tmpDir;
    }
    
    public function setTemporaryDir($tmpDir)
    {
        $this->tmpDir = $tmpDir;
        return $this;
    }
    
    public function getConcurrentSize()
    {
        return $this->concurrentSize;
    }
    
    public function setConcurrentSize($concurrentSize)
    {
        $this->concurrentSize = $concurrentSize;
        return $this;
    }
}

