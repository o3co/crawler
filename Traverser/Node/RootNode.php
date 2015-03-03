<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\AbstractTraverser;
use O3Com\Crawler\Traverser\Traversal;
use O3Com\Crawler\Traverser\Handler;

use O3Com\Crawler\Site;
use O3Com\Crawler\Exception\NoPageException;

/**
 * RootNode 
 * 
 * @uses AbstractTraverser
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class RootNode extends AbstractNode 
{
	protected $nodeFactory;

	protected $site;

	public function __construct(Site $site)
	{
		parent::__construct();

		$this->site = $site;
	}
	
    public function getSite()
    {
        return $this->site;
    }

	public function getNodeFactory()
	{
		return $this->getSite()->getNodeFactory();
	}

	public function end()
	{
		return $this->getSite();
	}

	public function visit($url, $method = 'GET', array $options = array())
	{
		$page = $this->getNodeFactory()->createPageNode($this);

		$this->getHandlers()->append(new Handler\NodeHandler($page));

		$page
			->onEnterTraverse(function($traversal) use ($url, $method, $options){
					// visit the page
					$traversal->visit($url, $method, $options);
				})
			->onLeaveTraverse(function($traversal) {
					// leave the page
					try {
						$traversal->back();
					} catch(NoPageException $ex) {
						// on root, back throw no page exception, if use history.
						// so we catch the exception at here.
					}
				})
		;

		return $page;
	}

	public function getCrawler(Traversal $traversal)
	{
		return $traversal->getCurrentPage()->getCrawler();
	}
}

