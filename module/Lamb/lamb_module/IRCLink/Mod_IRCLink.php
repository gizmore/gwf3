<?php
final class LambModule_IRCLink extends Lamb_Module
{
	private $links = array();
	private $links_saved = '';
	
	################
	### Triggers ###
	################
	public function onInit(Lamb_Server $server)
	{
		Lamb::instance()->addTimer($server, array($this, 'onInitC'), NULL, 4);
	}
	public function onInitC(Lamb_Server $server, $args) { $this->onInitB($server); }
	public function onInitB(Lamb_Server $server)
	{
		$this->links_saved = GWF_Settings::getSetting('lamb_irc_links', '');
//		echo "Loading irc_links: $this->links_saved.\n";
		$links = explode(';', $this->links_saved);
		foreach ($links as $i => $link)
		{
			if ($link === '') {
				unset($links[$i]);
				continue;
			}
			if ('' !== $this->checkLinkChain($link)) {
				unset($links[$i]);
//				echo "Removed Link from memory: $link";
			}
		}
		$this->links = array_values($links);
	}
	
	private function onReload(Lamb_Server $server)
	{
		$this->onInitB($server);
		Lamb::instance()->reply('Reloaded the Links. Number of active irc links: '.count($this->links).'.');
	}
	
	public function saveLinks()
	{
		return GWF_Settings::setSetting('lamb_irc_links', $this->links_saved);
	}

	###############
	### Getters ###
	###############
	public function getTriggers($priviledge)
	{
		switch ($priviledge)
		{
			case 'admin': return array('irc_link', 'irc_links_reload', 'irc_links_reset');
			default: return array();
		}
	}
	
	public function getHelp($trigger)
	{
		$help = array(
			'irc_link' => 'Usage: %TRIGGER%irc_link <servid:servchan> <servid:servchan> [servid:servchan]... Link 2 or more channels together.',
			'irc_links_reload' => 'Usage: %TRIGGER%irc_links_reload. Refresh the irc link table.',
			'irc_links_reset' => 'Usage: %TRIGGER%irc_links_reset [cleanup|truncate]. Drop non-active irc links or the whole table.',
		);
		return isset($help[$trigger]) ? $help[$trigger] : '';
	}
	
	################
	### Commands ###
	################
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $origin, $command, $message)
	{
		$out = '';
		switch ($command)
		{
			case 'irc_link'; $out = $this->onAddLink($server, $user, $from, $origin, $message); break;
			case 'irc_links_reload'; $out = $this->onReloadLinks($server, $user, $from, $origin, $message); break;
			case 'irc_links_reset'; $out = $this->onResetLinks($server, $user, $from, $origin, $message); break;
			default: return;
		}
		$server->reply($origin, $out);
	}
	
	public function onReloadLinks(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		$this->onInitB($server);
		return "IRC Links should have been reloaded.";
	}
	
	public function onResetLinks(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if ($message !== 'cleanup' && $message !== 'truncate')
		{
			return $this->onReloadLinks($server, $user, $from, $origin, $message);
		}
		
		if ($message === 'truncate') {
			$this->links = array();
			$msg = "All links have been deleted.";
		}
		else {
			$msg = "All inactive links have been deleted. Try to add truncate to flush all links.";
		}
		$this->links_saved = implode(';', $this->links);
		$this->saveLinks();
		return $msg;
	}
	
	public function onAddLink(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if ($message === '') {
			$count = count($this->links);
			return "I have $count active links.";
		}
		
		$links = preg_split('/ +/', $message);
		$the_link = array();
		foreach ($links as $link)
		{
			list($s, $chan) = explode(':', $link);
			$chan = strtolower($chan);
			if (false === ($serv = Lamb_Server::getByMsg($s))) {
				return 'Unknown Server: '.$s;
			}
			$sid = $serv->getID();
			$l = "$sid:$chan";
			if ('' !== ($error = $this->checkLink($l, true))) {
				return $error;
			}
			$the_link[] = $l;
		}
		
		$the_link = array_unique($the_link);
		
		if (count($the_link) < 2) {
			return "You need at least 2 different spam destinations.";
		}
		
		$the_link = implode(',', $the_link);
		$this->links[] = $the_link;
		if ($this->links_saved !== '') {
			$this->links_saved .= ';';
		}
		$this->links_saved .= $the_link;
		
		
		if (false === $this->saveLinks()) {
			return "DATABASE ERROR!";
		}
		
		return sprintf("Added IRC Link: %s", $the_link);
	}
	
	private function checkLinkChain($link, $no_dups=true)
	{
//		echo "Checking link chain: $link\n";
		$chain = explode(',', $link);
		foreach ($chain as $l)
		{
			if ('' !== ($err = $this->checkLink($l, $no_dups))) {
				return $err;
			}
		}	
		return '';
	}
	
	private function checkLink($link, $no_dups=false)
	{
		echo "Checking irc_link: $link\n";

		$a = explode(':', $link);
		if (count($a) !== 2) {
			return "Invalid settings: $link";
		}
		
		if (false === ($server = Lamb::instance()->getServer($a[0]))) {
			return "Wrong Server: $a[0]";
		}
		if (false === ($server->getChannel($a[1]))) {
			return "Wrong Channel: $a[1]";
		}
		
//		if ($no_dups)
//		{
//			foreach ($this->links as $l)
//			{
//				$l = explode(',', $l);
//				foreach ($l as $l2)
//				{
//					if ($l2 === $link)
//					{
//						return "Duplicate destination: $l2.";
//					}
//				}
//			}
//		}
		return '';
	}
	
	###############
	### PrivMSG ###
	###############
	public function onPrivmsg(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if ( (count($this->links) === 0) || (preg_match('/^\x02/', $message)) )
		{
//			echo "IRCLink ignored privmsg.\n";
			return;
		}
		foreach ($this->links as $link)
		{
			$this->onPrivmsgB($server, $user, $link, $origin, $message);
		}
	}

	private function onPrivmsgB(Lamb_Server $server, Lamb_User $user, $link, $origin, $message)
	{
		echo __METHOD__."($link)";
		$targets = explode(',', $link);
		$spam = false;
		foreach ($targets as $i => $target)
		{
			list($sid, $chan) = explode(':', $target);
			$sid2 = $server->getID();
			if ($origin === $chan && $sid == $sid2) {
				unset($targets[$i]);
				$spam = true;
			}
		}
		if (!$spam)  {
			return;
		}
		$b = chr(2);
			
		$lamb = Lamb::instance();
		foreach ($targets as $target)
		{
			list($sid, $chan) = explode(':', $target);
			if (false === ($s = $lamb->getServer($sid))) {
				echo "Can not spam server $sid.\n";
				continue;
			}
			if (false === ($c = $s->getChannel($chan))) {
				echo "Can not spam server $sid channel $chan.\n";
				continue;
			}
			$s->sendPrivmsg($chan, sprintf("<$b%s:%s$b>: %s", $server->getID(), $user->getName(), $message));
		}
	}
}
?>