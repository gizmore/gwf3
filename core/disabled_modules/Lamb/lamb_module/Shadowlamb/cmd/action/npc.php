<?php
require_once 'core/module/Lamb/lamb_module/Shadowlamb/cmd/gm/gmd.php';
final class Shadowcmd_npc extends Shadowcmd_gmd
{
	public static function isCombatCommand() { return true; }
	
	public static $WHITELIST = array('u','ca','le','sell','buy','view','drop','eq','uq','x','fw','bw','#','i','q','ks','a','s','l');
	
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) < 1)
		{
			$player->message(Shadowhelp::getHelp($player, 'npc'));
			return false;
		}

		$party = $player->getParty();
		if (false === ($remote = $party->getMemberByArg(array_shift($args))))
		{
			$player->msg('1064');
// 			$player->message('This player is not in your party.');
			return false;
		}

		if ($remote->isHuman())
		{
			$player->msg('1065');
// 			$player->message('You can only remote control NPC.');
			return false;
		}
		
		if (!in_array($args[0], self::$WHITELIST, true))
		{
			$player->msg('1066', array(implode(', ', self::$WHITELIST)));
// 			$player->message(sprintf('Only the following remote commands are allowed: %s.', implode(', ', self::$WHITELIST)));
			return false;
		}
		
		return self::onRemote($player, $remote, $args);
	}
}
?>