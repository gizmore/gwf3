<?php
final class Shadowcmd_part extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 0) {
			$bot->reply(Shadowhelp::getHelp($player, 'part'));
			return false;
		}
		$p = $player->getParty();
		if ($p->getMemberCount() === 1) {
			$bot->reply('You are not in a party.');
			return false;
		}
		
		$p->notice(sprintf('%s has left the party.', $player->getName()));
		$p->kickUser($player, true);
		$np = SR_Party::createParty();
		$np->addUser($player, true);
		$np->cloneAction($p);
		
		if ($np->isMoving())
		{
			Shadowcmd_stop::execute($player, $args);
		}
		
		return true;
	}
}
?>
