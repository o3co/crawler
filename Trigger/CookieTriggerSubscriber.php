<?php
namespace O3Com\Crawler\Trigger;

use O3Com\Crawler\TriggerSubscriber;
use O3Com\Crawler\Traverser\Traversal;

class CookieTriggerSubscriber implements TriggerSubscriber
{
	static public function getSubscribedTriggers()
	{
		return array(
				'expireCookie' => 'expireCookie',
			);
	}

	public function expireCookie(Traversal $traversal, $name, $path, $domain)
	{
		$client = $traversal->getClient();
		$client->getCookieJar()->expire($name, $path, $domain);
	}
}

