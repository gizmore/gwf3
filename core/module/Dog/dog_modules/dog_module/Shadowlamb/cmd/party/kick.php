<?php
final class Shadowcmd_kick extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'kick'));
			return false;
		}
		
		$p = $player->getParty();
		if (false === ($target = $p->getMemberByArg($args[0])))
		{
			$player->msg('1089');
// 			$bot->reply('This player is not in your party.');
			return false;
		}
		
		if ($target->getID() === $player->getID())
		{
			$player->msg('1090');
// 			$bot->reply('You can not kick yourself.');
			return false;
		}
		
		$p->ntice('5137', array($target->getName()));
// 		$p->notice(sprintf('%s has been kicked off the party.', $target->getName()));
		if ($p->kickUser($target, false))
		{
			$p->recomputeEnums();
			$p->updateMembers();
			$np = SR_Party::createParty();
			$np->cloneAction($p);
			$np->clonePreviousAction($p);
			$np->addUser($target, true);
			if (!$np->isIdle())
			{
				$np->popAction(true);
			}
		}
		
		return true;
	}
}
?>
