<?php
final class Shadowcmd_gmx extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) !== 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'gmx'));
			return false;
		}
		
		if (false === ($p1 = Shadowrun4::getPlayerByName($args[0])))
		{
			$player->message(sprintf('%s is unknown or not in memory.', $args[0]));
			return false;
		}

		if (false === ($p2 = Shadowrun4::getPlayerByName($args[1])))
		{
			$player->message(sprintf('%s is unknown or not in memory.', $args[1]));
			return false;
		}
		
		if ($p1->getID() === $p2->getID())
		{
			$player->message('Funny!');
			return false;
		}
		
		$pp1 = $p1->getParty();
		if ($pp1->getMemberCount() > 1)
		{
			$player->message(sprintf('%s is in a party.', $args[0]));
			return false;
		}
		if (!$pp1->isIdle())
		{
			$player->message(sprintf('%s is not idle.', $args[0]));
			return false;
		}
		
		$pp2 = $p2->getParty();
		if ($pp2->getMemberCount() > 1)
		{
			$player->message(sprintf('%s is in a party.', $args[1]));
			return false;
		}
		if (!$pp2->isIdle())
		{
			$player->message(sprintf('%s is not idle.', $args[1]));
			return false;
		}
		
		return self::exchangePlayers($player, $p1, $p2);
	}
	
	private static function exchangePlayers(SR_Player $player, SR_Player $p1, SR_Player $p2)
	{
		$u1 = $p1->getUser();
		$u2 = $p2->getUser();
		
		if (false === $p1->saveVar('sr4pl_uid', $u2->getID()))
		{
			$player->message('Database error 1');
			return false;
		}
		$p1->setVar('sr4pl_uid', $u2);
		
		if (false === $p2->saveVar('sr4pl_uid', $u1->getID()))
		{
			$player->message('Database error 2');
			return false;
		}
		$p2->setVar('sr4pl_uid', $u1);
		
		$player->message(sprintf('Switched players!'));
		return true;
	}
}
?>