<?php
final class Shadowcmd_hunt extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkLeader($player))) {
			$bot->reply($error);
			return false;
		}
		
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'hunt'));
			return false;
		}
		
		$target = Shadowrun4::getPlayerByShortName($args[0]);
		if ($target === false) {
			$bot->reply('This player is not in memory.');
			return false;
		}
		if ($target === -1) {
			$bot->reply('The player name is ambigous. Try the {server} version.');
			return false;
		}
		$name = $target->getName();
		
		$p = $player->getParty();
		$ep = $target->getParty();
		if ($p->getID() === $ep->getID()) {
			$bot->reply('You cannot hunt own party members.');
			return false;
		}
		
		if ($p->getCity() !== $ep->getCity()) {
			$bot->reply(sprintf('You cannot hunt %s because you are in %s and %s is in %s.', $name, $p->getCity(), $name, $ep->getCity()));
			return false;
		}
		
		$city = $p->getCityClass();
		$eta = round($city->getExploreETA($p) * 1.2);
		$p->pushAction(SR_Party::ACTION_HUNT, $target->getName().' in '.$city->getName(), $eta);
		$p->setContactEta(rand(10,20));
		$p->notice(sprintf('You start to hunt %s. ETA: %s.', $target->getName(), GWF_Time::humanDuration($eta)));
		return true;
	}
}
?>
