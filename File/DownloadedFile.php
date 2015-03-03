<?php
namespace O3Com\Crawler\File;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser,
	Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser
;

/**
 * TemporaryFile 
 *   Create new file from the response 
 * 
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class DownloadedFile extends File 
{
	static protected $extensionGuesser;

	static public function getExtensionGuesser()
	{
		if(!self::$extensionGuesser) {
			self::$extensionGuesser = new MimeTypeExtensionGuesser();
		}
		return self::$extensionGuesser;
	}


	private $originalName;

	private $mimeType;

	private $size;

	private $url;

	public function __construct($path, $url, $originalName, $mimeType = null, $size = null)
	{
		parent::__construct($path, true);
		$this->url = $url;
		$this->originalName = $originalName;
		$this->mimeType = $mimeType;

		if(!$size) {
			$size = filesize($path);
		}
		$this->size = $size;
	}

	public function getExtension()
	{
		$type = $this->getMimeType();
		$guesser = self::getExtensionGuesser();

		return $guesser->guess($type);
	}

	public function getSize()
	{
		return $this->info['content-length'];
	}

    public function getOriginalName()
    {
        return $this->originalName;
    }
    
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
        return $this;
    }
    
    public function getMimeType()
    {
        return $this->mimeType;
    }
    
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        return $this;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

	public function move($dir, $name = null) 
	{
		if(!$this->isStreamPath($dir)) {
			return parent::move($dir, $name);
		} else {
			// use file_put_content instead.
			try {
				$fp = fopen($this->getPathname(), 'r');
				if(!$fp) {
					throw new \RuntimeException('Failed to open file');
				}
				file_put_contents($dir . '/' . $name, $fp);
				
				fclose($fp);
			} catch(\Exception $ex) {
				if($fp) {
					fclose($fp);
				}
				throw $ex;
			}

			return $dir . '/' . $name;
		}
	}

	public function isStreamPath($path)
	{
		return (bool)preg_match('/^\w+:\/\//', $path);
	}
}

