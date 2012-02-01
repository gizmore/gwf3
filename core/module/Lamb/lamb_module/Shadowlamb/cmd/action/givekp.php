<?php
class Shadowcmd_givekp extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if ($player->isFighting())
		{
			$player->msg('1036');
// 			$player->message('This does not work in combat');
			return false;
		}
		if (count($args) !== 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'givekp'));
			return false;
		}
		if (false === ($target = Shadowfunc::getFriendlyTarget($player, $args[0])))
		{
			$player->msg('1028', array($args[0]));
// 			$player->message(sprintf('%s is not here or the name is ambigous.', $args[0]));
			return false;
		}
		return self::giveKnow($player, $target, 'places', $args[1]);
	}
	
	public static function giveKnow(SR_Player $player, SR_Player $target, $what, $which)
	{
		if (false === $player->hasKnowledge($what, $which))
// 		if (false === ($which = $player->getKnowledgeByArg($what, $which)))
		{
			$player->msg('1023');
// 			$player->message('You don`t have this knowledge.');
			return false;
		}
		
		if (!$target->hasKnowledge($what, $which))
		{
			$target->giveKnowledge($what, $which);
			$player->getParty()->ntice('5117', array($player->getName(), $target->getName(), $which));
// 			$player->getParty()->message($player, sprintf(' told %s about %s.', $target->getName(), $which));
		}
		
		return true;
	}
}
?>
