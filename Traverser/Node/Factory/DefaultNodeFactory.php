<?php
namespace O3Com\Crawler\Traverser\Node\Factory;

use O3Com\Crawler\Traverser\Node;
use O3Com\Crawler\Traverser\Node\Factory;

/**
 * DefaultNodeFactory 
 * 
 * @uses Factory
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class DefaultNodeFactory implements Factory 
{
	public function createChildNode($type, Node $parentNode, array $args = array())
	{
		switch($type) {
		case 'page':
			return $this->createPageNode($parentNode, $args);
		case 'form':
			return $this->createFormNode($parentNode, $args['selector']);
		case 'pager':
			return $this->createPageNode($parentNode, $args['selecctor']);
		case 'each':
			return $this->createEachNode($parentNode, $args['condition']);
		default:
			throw new \InvalidArgumentException(sprintf('Unknow type of node "%s" to create', $type));
		}
	}

	public function createEachNode(Node $parentNode, $condition)
	{
		return new Node\EachNode($parentNode, $condition);
	}

	public function createPageNode(Node $parentNode, array $args = array())
	{
		return new Node\PageNode($parentNode, $args);
	}

	public function createPagerNode(Node $parentNode, $selector, array $options = array())
	{
		return new Node\PagerNode($parentNode, $selector);
	}

	public function createFormNode(Node $parentNode, $selector, array $options = array())
	{
		return new Node\FormNode($parentNode, $selector);
	}
}

