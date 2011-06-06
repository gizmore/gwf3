<?php
final class Shadowcmd_npc extends Shadowcmd_gmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) < 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'npc'));
			return false;
		}
		
		$party = $player->getParty();
		if (false === ($remote = $party->getMemberByArg(array_shift($args))))
		{
			$player->message('This player is not in your party.');
			return false;
		}

		if ($remote->isHuman())
		{
			$player->message('You can only remote control NPC.');
			return false;
		}
		
		return self::onRemote($player, $remote, $args);
	}
}
?>