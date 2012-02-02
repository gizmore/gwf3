<?php
final class Shadowcmd_join extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'join'));
			return false;
		}

		if (false === ($target = Shadowfunc::getFriendlyTarget($player, $args[0], false)))
		{
			self::rply($player, '1028', array($args[0]));
// 			$bot->reply(sprintf('%s is not here or you are in his/her party already.', $args[0]));
			return false;
		}

		if ($target->getParty()->getLeader()->isNPC())
		{
			self::rply($player, '1085');
// 			$bot->reply('You cannot join NPC parties.');
			return false;
		}
		
		if ($target->getPartyID() === $player->getPartyID())
		{
			self::rply($player, '1086');
// 			$bot->reply('You cannot join your own party.');
			return false;
		}
		
		$p = $player->getParty();
		$ep = $target->getParty();
		if ($ep->hasBanned($player))
		{
			self::rply($player, '1087');
// 			$bot->reply(sprintf('The party does not want you to join.'));
			return false;
		}
		
		if ($ep->isFull())
		{
			self::rply($player, '1088', array(SR_Party::MAX_MEMBERS));
// 			$bot->reply('The party has reached the maximum membercount of '.SR_Party::MAX_MEMBERS.'.');
			return false;
		}
		
		$p->kickUser($player, true);
		$ep->addUser($player, true);
		
		$p->ntice('5135', array($player->getName()));
		$ep->ntice('5136', array($player->getName()));
// 		$p->notice(sprintf('%s left the party.', $player->getName()));
// 		$ep->notice(sprintf('%s joined the party.', $player->getName()));
		
		if ($p->isTalking() && $p->getMemberCount() === 0)
		{
			$p->popAction(true);
			$ep->popAction(true);
		}
		
		return true;
	}
}
?>
