<?php
class SR_ClanHQ extends SR_Location
{
	public function getFoundText(SR_Player $player)
	{
		return sprintf('You found the clan headquarters.');
	}
	
	public function getEnterText(SR_Player $player)
	{
		return sprintf('You enter the clan headquarters.');
	}
	
	public function getHelpText(SR_Player $player)
	{
		$c = Shadowrun4::SR_SHORTCUT;
		return "You can join clans here with {$c}request, {$c}accept and {$c}manage. You can access clan bank with {$c}push and {$c}pop. You can access clan money with {$c}pushy and {$c}popy.";
	}
	
	public function getCommands($player)
	{
		return array('request', 'accept', 'manage', 'push', 'pop', 'pushy', 'popy');
	}
	
	public function on_request(SR_Player $player, array $args)
	{
		if (false !== ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->message(sprintf('You are already in the clan "%s".', $clan->getName()));
			return false;
		}
		
		if (count($args) === 0)
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_request'));
			return false;
		}
		
		if (false === ($clan = SR_Clan::getByName($args[0])))
		{
			$player->message('This clan is unknown.');
			return false;
		}
		
		if ($clan->isModerated())
		{
			
			$clan->sendRequest($player, $args[1]);
		}
		else
		{
			
		}
		
	}

	public function on_accept(SR_Player $player, array $args)
	{
		
	}

	public function on_manage(SR_Player $player, array $args)
	{
		
	}

	public function on_push(SR_Player $player, array $args)
	{
		
	}

	public function on_pop(SR_Player $player, array $args)
	{
		
	}

	public function on_pushy(SR_Player $player, array $args)
	{
		
	}

	public function on_popy(SR_Player $player, array $args)
	{
		
	}
}
?>