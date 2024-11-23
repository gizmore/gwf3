<?php
final class Shadowcmd_gms extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'gmstats'));
			return false;
		}
		if (false !== ($npc = Shadowrun4::getPlayerByShortName($args[0]))) {
		}
		elseif ($npc === -1) {
			$bot->reply('The playername is ambigious.');
			return false;
		}
		elseif (false !== ($npc = Shadowrun4::getPlayerByPID($args[0]))) {
		}
		else {
			$bot->reply('The player '.$args[0].' is not in memory.');
			return false;
		}
		
		$player->message(Shadowfunc::getStatus($npc, '5301'));
		$player->message(Shadowfunc::getEquipment($npc, '5303'));
		$player->message(Shadowfunc::getAttributes($npc, '5304'));
		$player->message(Shadowfunc::getSkills($npc, '5305'));
//		$bot->reply(sprintf('Party: %s.', Shadowfunc::getPartyStatus($npc)));
		return true;
	}
}
?>
