<?php
namespace O3Com\Crawler\Traverser\Handler;

class VisitHandler extends 
{
	public function __construct($url, $method = 'GET', array $options = array(), Node $nextNode = null)
	{
		$this->url = $url;
		$this->method = $method;
		$this->options = $options;

		parent::__construct($nextNode);
	}

	public function handle(Traversal $traversal, array $options = array())
	{
		$traversal->visit($this->getUrl(), $this->getMethod(), $this->getOptions());

		$this->getNextNode()->traverse($traversal);
	}
}
