<?php
namespace O3Com\Crawler\Traverser\Node;

use O3Com\Crawler\Traverser\Node;
use O3Com\Crawler\Traverser\Handler;
use O3Com\Crawler\Traverser\Traversal;

/**
 * ContentNode 
 * 
 * @uses ChildNode
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
abstract class ContentNode extends ChildNode
{
	protected function initHandlers()
	{
		$this->rootHandler = new Handler\ExceptionHandler(new Handler\SequentialHandler());
	}

	public function getHandlers()
	{
		return $this->getRootHandler()->getHandler();
	}

	public function pager($condition = null)
	{
		$pager = $this->getNodeFactory()->createPagerNode($this, $condition);

		$this->getHandlers()->append(new Handler\NodeHandler($pager));

		return $pager;
	}
}

