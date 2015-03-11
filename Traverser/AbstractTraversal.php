<?php
namespace O3Co\Crawler\Traverser;

abstract class AbstractTraversal implements Traversal 
{
	private $configs;

	public function createNodeTraversal(Node $node)
	{
		$configs = clone $this->configs;
		return new NodeTraversal($this, $node, $configs);
	}

    public function getConfigs()
    {
        return $this->configs;
    }
    
    public function setConfigs(array $configs)
    {
        $this->configs = $configs;
        return $this;
    }

	public function set($key, $value)
	{
		$this->configs[$key] = $value;
	}

	public function has($key)
	{
		return isset($this->configs[$key]);
	}

	public function get($key, $default = null)
	{
		return isset($this->configs[$key]) ? $this->configs[$key] : $default;
	}

	public function dispatch($eventName, $event)
	{
		$this->getEventDispatcher()->dispatch($eventName, $event);
	}
}
