<?php
class Shadowcmd_givekp extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if ($player->isFighting())
		{
			$player->message('This does not work in combat');
			return false;
		}
		if (count($args) !== 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'givekp'));
			return false;
		}
		if (false === ($target = Shadowfunc::getFriendlyTarget($player, $args[0])))
		{
			$player->message(sprintf('%s is not here or the name is ambigous.', $args[0]));
			return false;
		}
		return self::giveKnow($player, $target, 'places', $args[1]);
	}
	
	public static function giveKnow(SR_Player $player, SR_Player $target, $what, $which)
	{
		if (false === ($which = $player->getKnowledgeByArg($what, $which)))
		{
			$player->message('You don`t have this knowledge.');
			return false;
		}
		if (!$target->hasKnowledge($what, $which))
		{
			$target->giveKnowledge($what, $which);
			$player->message(sprintf('You told %s about %s.', $target->getName(), $which));
		}
		return true;
	}
}
?>
