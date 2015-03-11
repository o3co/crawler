<?php
namespace O3Co\Crawler\Traverser\Node;

use O3Co\Crawler\Traverser\Node;
use O3Co\Crawler\Traverser\Handler;
use O3Co\Crawler\Traverser\Traversal;
use O3Co\Crawler\Exception\CssSelectorException;

/**
 * FormNode 
 * 
 * @uses TraverseConditionNode
 * @package { PACKAGE }
 * @copyright Copyrights (c) 1o1.co.jp, All Rights Reserved.
 * @author Yoshi<yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
class FormNode extends PartialNode 
{
	const KEY_DATA = 'form.data';

	const KEY_FORM = 'form';

	public function traverse(Traversal $traversal) 
	{
		$form = $traversal->get(self::KEY_FORM);
		$data = $traversal->get(self::KEY_DATA);
		//
		$traversal->set(self::KEY_FORM, null);
		$traversal->set(self::KEY_DATA, array());
		parent::traverse($traversal);
		// recover previous form
		$traversal->set(self::KEY_FORM, $form);
		$traversal->set(self::KEY_DATA, $data);
	}

	/**
	 * getForm 
	 * 
	 * @param Traversal $traversal 
	 * @access public
	 * @return void
	 * 
	 * @throws CssSelectorException If form is not exists.
	 */
	public function getForm(Traversal $traversal)
	{
		$form = $traversal->get(self::KEY_FORM);
		if($form) {
			return $form;
		}
		try {
			$form = $this->getCrawler($traversal)->form();

			$traversal->set(self::KEY_FORM, $form);

			return $form;
		} catch(\InvalidArgumentException $ex) {
			throw new CssSelectorException(sprintf('Form "%s" is not exists.', $this->getSelector($traversal)));
		}
	} 

	public function getFormValues(Traversal $traversal)
	{
		$form = $this->getForm($traversal);
		$values = $form->getValues();

		$data = $traversal->get(self::KEY_DATA, array());
		foreach($data as $key => $value) {
			try {
				$values[$key] = $value;
			} catch(\InvalidArgumentException $ex) {
				//throw new \InvalidArgumentException(sprintf('Field "%s" is not exists on form "%s".', $key, $this->getSelector($traversal)));
			}
		}

		return $values;
	}

	public function resetForm(Traversal $traversal)
	{
		$traversal->set(self::KEY_FORM, null);
	}

	/**
	 * setData 
	 *   Register handler to update data on form 
	 *   $data is either an array or closure($traversal, $form)
	 * 
	 * @param array|closure $data 
	 * @access public
	 * @return $this
	 */
	public function setData($data)
	{
		$this->initSetDataHandlers($this, $data);
		return $this;
	}

	public function set($key, $value)
	{
		$this->initSetHandlers($this, $key, $value);
		return $this;
	}

	/**
	 * submit 
	 *   Add traverser node to submit form.
	 *   
	 * @access public
	 * @return PageNode Forwarded page.
	 */
	public function submit($action = null, $method = null)
	{
		$page = $this->getNodeFactory()->createPageNode($this);

		// add Node traverse handler
		$this->getHandlers()->append(new Handler\NodeHandler($page));
		$this->initSubmitHandlers($page, $action, $method);

		return $page;
	}

	/**
	 * send 
	 *   Send the form data as emulating form submit. 
	 * @param mixed $action 
	 * @param mixed $method 
	 * @access public
	 * @return void
	 */
	public function send($action = null, $method = null, \Closure $send = null)
	{
		$page = $this->getNodeFactory()->createPageNode($this);

		// add Node traverse handler
		$this->getHandlers()->append(new Handler\NodeHandler($page));
		$this->initSendValueHandlers($page, $action, $method, $send);

		return $page;
	}

	public function initSetDataHandlers(Node $node, $data)
	{
		$node->getHandlers()->prepend(new Handler\ExecuteHandler(function($traversal) use ($data) {
				if(is_callable($data)) {
					$data = $data($traversal, $this->getForm($traversal));
				}
				
				// update form data
				$traversal->set(self::KEY_DATA, $data);
			}));
	}

	public function initSetHandlers(Node $node, $key, $value)
	{
		$node->getHandlers()
			->append(new Handler\ExecuteHandler(function($traversal) use ($key, $value) {
					$data = $traversal->get(self::KEY_DATA, array());
					if(is_callable($value)) {
						$value = $value($traversal);
					}
					$data[$key] = $value;

					$traversal->set(self::KEY_DATA, $data);
				}))
		;
	}

	public function initSendValueHandlers(PageNode $page, $action = null, $method = null, $send = null) 
	{
		$page
			->onEnterTraverse(function($traversal) use($action, $method, $send) {
					$form = $this->getForm($traversal);
					if($action) {
						// update action of form
						$form->getNode()->setAttribute('action', $action);
					}

					if($method) {
						// update action of form
						$form->getNode()->setAttribute('method', $action);
					}

					$url = $form->getUri();
					$method = $form->getMethod();
					$form   = $form->getValues();

					$data = $traversal->get(self::KEY_DATA, array());
					foreach($data as $key => $value) {
						try {
							$form[$key] = $value;
						} catch(\InvalidArgumentException $ex) {
							throw new \InvalidArgumentException(sprintf('Field "%s" is not exists on form "%s".', $key, $this->getSelector($traversal)));
						}
					}
					
					if(!$send) {
						$send = function($traversal, $url, $method, $values) {
							$content = http_build_query($values);
							$traversal->visit($url, $method, array('server' => array('HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded', 'content' => $content)));
						};
					}

					$send($traversal, $url, $method, $form);
				})
			// ending the traversing
			->onLeaveTraverse(function($traversal) {
					$traversal->back();	
				})
		;
	}

	public function initSubmitHandlers(PageNode $page, $action = null, $method = null) 
	{
		$page
			->onEnterTraverse(function($traversal) use($action, $method) {
					$form = $this->getForm($traversal);
					if($action) {
						// update action of form
						$form->getNode()->setAttribute('action', $action);
					}

					if($method) {
						// update action of form
						$form->getNode()->setAttribute('method', $action);
					}

					$data = $traversal->get(self::KEY_DATA, array());
					foreach($data as $key => $value) {
						try {
							$form[$key] = $value;
						} catch(\InvalidArgumentException $ex) {
							throw new \InvalidArgumentException(sprintf('Field "%s" is not exists on form "%s".', $key, $this->getSelector($traversal)));
						}
					}
					
					$traversal->forwardByForm($form);
				})
			// ending the traversing
			->onLeaveTraverse(function($traversal) {
					$traversal->back();	
				})
		;
	}
}

