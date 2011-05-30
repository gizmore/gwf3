<?php
final class Shadowcmd_join extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'join'));
			return false;
		}

		if (false === ($target = Shadowfunc::getFriendlyTarget($player, $args[0], false)))
		{
			$bot->reply(sprintf('%s is not here or you are in his/her party already.', $args[0]));
			return false;
		}
		
//		if (false === ($target = Shadowfunc::getPlayerInLocationB($player, $args[0]))) {
//			return false;
//		}
		
		if ($target->getID() === $player->getID()) {
			$bot->reply('You cannot join yourself.');
			return false;
		}
		
		$p = $player->getParty();
		$ep = $target->getParty();
		if ($ep->hasBanned($player)) {
			$bot->reply(sprintf('The party does not want you to join.'));
			return false;
		}
		
		if ($p->isFull()) {
			$bot->reply('The party has reached the maximum membercount of '.SR_Party::MAX_MEMBERS.'.');
			return false;
		}
		
		$p->kickUser($player, true);
		$ep->addUser($player, true);
		$p->notice(sprintf('%s left the party.', $player->getName()));
		$ep->notice(sprintf('%s joined the party.', $player->getName()));
		
		if ($p->isTalking() && $p->getMemberCount() === 0) {
			$p->popAction();
			$ep->popAction(true);
		}
		
		return true;
	}
}
?>
