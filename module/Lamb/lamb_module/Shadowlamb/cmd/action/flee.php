<?php
final class Shadowcmd_flee extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$party = $player->getParty();
		
		if ($party->flee($player) === true)
		{
			$party->notice(sprintf('%s has fled from the enemy.', $player->getName()));
			$party->getEnemyParty()->notice(sprintf('%s has fled from combat.', $player->getName()));
			$party->kickUser($player, true);
			$np = SR_Party::createParty();
			$np->addUser($player, true);
			$np->cloneAction($party);
			$np->clonePreviousAction($party);
			$np->popAction(true);
		}
		
		else
		{
			$busy = $player->busy(40);
			$party->notice(sprintf('%s tried to flee from the combat. %s busy.', $player->getName(), GWF_Time::humanDuration($busy)));
		}
		
		return true;
	}
}
?>
