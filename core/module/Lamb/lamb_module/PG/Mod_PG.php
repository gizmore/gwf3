<?php
require_once 'Lamb_PG.php';
/**
 * Some anti annoyance filters.
 * @author gizmore
 * @version 1.0
 */
final class LambModule_PG extends Lamb_Module
{
	const CAPS_LOCK = false;
	const CAPS_LOCK_RATIO = 0.80;
	const CAPS_MINLEN = 10;
	
	const HIGHLIGHT = true;
	const HIGHLIGHT_MAX = 5;
	
	const BAN_COUNT = 5;
	const BAN_TIMEOUT = 86400;
	
	public function onInstall() { GDO::table('Lamb_PG')->createTable(); }
	public function onNotice(Lamb_Server $server, Lamb_User $user, $from, $origin, $message) { $this->onPG($server, $user, $from, $origin, $message); }
	public function onPrivmsg(Lamb_Server $server, Lamb_User $user, $from, $origin, $message) { $this->onPG($server, $user, $from, $origin, $message); }

	private function onPG(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if ($user->isBot()) {
			return;
		}
		
		if (false === ($channel = $server->getChannel($origin)))
		{
//			echo "Unknown channel: $origin\n";
			return;
		}
		
		if (self::CAPS_LOCK === true)
		{
			$this->onCapslockFlood($server, $channel, $user, $message);
		}
		if (self::HIGHLIGHT === true)
		{
			$this->onHighlightFlood($server, $channel, $user, $message);
		}
	}
	
	private function kick(Lamb_Server $server, Lamb_Channel $channel, Lamb_User $user, $message)
	{
		Lamb_PG::onKick($server, $channel, $user, $message);
	}

	private function onHighlightFlood(Lamb_Server $server, Lamb_Channel $channel, Lamb_User $user, $message)
	{
		$count = 0;
		$nicknames = preg_split('/ +/', $message);
		
		$users = array_keys($channel->getUsers());
		
//		var_dump($users);

		$nicknames = array_unique(array_map('strtolower', $nicknames));
		
		foreach ($nicknames as $nickname)
		{
//			echo "checking '$nickname'\n";
			foreach ($users as $username)
			{
				if (strcasecmp($username, $nickname) === 0) {
					$count++;
					break;
				}
			}
		}
		
//		echo "PGCOUNT: $count\n";
		
		if ($count >= self::HIGHLIGHT_MAX) {
			$this->kick($server, $channel, $user, "Do not mass-highlight!");
		}
	}

	private function onCapslockFlood(Lamb_Server $server, Lamb_Channel $channel, Lamb_User $user, $message)
	{
		if (strlen($message) < self::CAPS_MINLEN)
		{
			return;
		}
		
		$lower = 0;
		$upper = 0;
		$total = 0;
		$len = strlen($message);
		for ($i = 0; $i < $len; $i++)
		{
			$c = $message{$i};
			if ($c >= 'a' && $c <= 'z')
			{
				$lower++;
			}
			elseif ($c >= 'A' && $c <= 'Z')
			{
				$upper++;
			}
			else
			{
				continue;
			}
			$total++;
		}
		
		$ratio = $upper / $total;
		if ($ratio >= self::CAPS_LOCK_RATIO)
		{
			$this->kick($server, $channel, $user, "Please turn off caps lock!");
		}
	}
}
?>