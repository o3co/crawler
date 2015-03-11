<?php
namespace O3Co\Crawler\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

class Event extends BaseEvent 
{
	private $args;

	public function __construct(array $args = array())
	{
		$this->args = $args;
	}

    public function get($key)
    {
        if(!$this->has($key)) {
			throw new \InvalidArgumentExcpetion(sprintf('Event dose not have "%s"', $key));
		}
        return $this->args[$key];
    }
    
    public function set($key, $value)
    {
        $this->args[$key] = $value;
        return $this;
    }

	public function has($key)
	{
		return array_key_exists($key, $this->args);
	}
}

