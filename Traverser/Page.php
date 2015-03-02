<?php
namespace O3Com\Crawler\Traverser;

use Symfony\Component\BrowserKit\Request, 
	Symfony\Component\BrowserKit\Response; 
use Symfony\Component\DomCrawler\Crawler; 

class Page 
{
	const DEFAULT_CONTENT = '_default';

	protected $request;

	protected $response;

	protected $crawler;

	protected $values;

	protected $contents;

	public function __construct(Request $request, Response $response, Crawler $crawler)
	{
		$this->request  = $request;
		$this->response = $response;
		$this->crawler  = $crawler;
		$this->contents = array();

		$this->values   = array();
	}

	public function has($key)
	{
		return isset($this->values[$key]);
	}

	public function set($key, $value)
	{
		$this->values[$key] = $value;
	}

	public function get($key)
	{
		return $this->values[$key];
	}
    
    public function getRequest()
    {
        return $this->request;
    }
    
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }
    
    public function getResponse()
    {
        return $this->response;
    }
    
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }
    
    public function getCrawler()
    {
        return $this->crawler;
    }
    
    public function setCrawler($crawler)
    {
        $this->crawler = $crawler;
        return $this;
    }
    
    public function getContents()
    {
        return $this->contents;
    }
    
    public function setContents(array $contents)
    {
        $this->contents = $contents;
        return $this;
    }

	public function hasContent($alias = self::DEFUALT_CONTENT) 
	{
		return isset($this->contents[$alias]);
	}

	public function getContent($alias = self::DEFAULT_CONTENT)
	{
		return $this->contents[$alias];
	}

	public function setContent($content, $alias = self::DEFAULT_CONTENT)
	{
		$this->contents[$alias] = $content;
	}
}

