<?php
namespace O3Co\Crawler;

/**
 * SiteRegistry 
 * 
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class SiteRegistry 
{
	/**
	 * sites 
	 * 
	 * @var array
	 * @access private
	 */
	private $sites = array();

	/**
	 * hasSite 
	 * 
	 * @param mixed $name 
	 * @access public
	 * @return void
	 */
	public function hasSite($name)
	{
		return isset($this->sites[$name]);
	}

	/**
	 * getSite 
	 * 
	 * @param mixed $name 
	 * @access public
	 * @return void
	 */
	public function getSite($name)
	{
		if(!isset($this->sites[$name])) {
			throw new \InvalidArgumentException(sprintf('Site "%s" is not exists.', $name));
		}
		return $this->sites[$name];
	}

	/**
	 * addSite 
	 * 
	 * @param mixed $name 
	 * @param Site $site 
	 * @access public
	 * @return void
	 */
	public function addSite($name, Site $site)
	{
		$this->sites[$name] = $site;
	}

	/**
	 * removeSite 
	 * 
	 * @param mixed $name 
	 * @access public
	 * @return void
	 */
	public function removeSite($name)
	{
		unset($this->sites[$name]);
	}
}

