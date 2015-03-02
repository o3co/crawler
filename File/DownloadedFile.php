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

	private $path;

	private $originalName;

	private $mimeType;

	private $size;

	public function __construct($path, $originalName, $mimeType = null, $size = null)
	{
		parent::__construct($path, true);
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

    
    public function getPath()
    {
        return $this->path;
    }
    
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
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
}

