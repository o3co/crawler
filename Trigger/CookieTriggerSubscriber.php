<?php
namespace O3Co\Crawler\Trigger;

use O3Co\Crawler\TriggerSubscriber;
use O3Co\Crawler\Traverser\Traversal;

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

