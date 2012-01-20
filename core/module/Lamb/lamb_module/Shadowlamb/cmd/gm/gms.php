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
		$bot->reply(sprintf('Status for %s: %s', $npc->getName(), Shadowfunc::getStatus($npc)));
		$bot->reply(sprintf('Equipment: %s', Shadowfunc::getEquipment($npc)));
		$bot->reply(sprintf('Attributes: %s', Shadowfunc::getAttributes($npc)));
		$bot->reply(sprintf('Skills: %s', Shadowfunc::getSkills($npc)));
//		$bot->reply(sprintf('Party: %s.', Shadowfunc::getPartyStatus($npc)));
		return true;
	}
}
?>
