<?php
final class SR_BadKarma
{
	public static function onFight(SR_Player $player, SR_Party $ep)
	{
		$p = $player->getParty();
		$l1 = $player->get('level');
		
		$add = 0.00;
		
		foreach ($ep->getMembers() as $e)
		{
			$e instanceof SR_Player;
			if (!$e->isHuman())
			{
				continue;
			}
			
			
			$badkarma = $e->getBase('bad_karma');
			if ($badkarma > 0)
			{
				continue;
			}
			
			
//			$bounty = $e->getBase('sr4pl_bounty');

			
			$l2 = $e->get('level');
			$diff = $l1 - $l2;
			if ($diff < 0)
			{
				continue;
			}
			
			$add += round($diff / 100, 2);
		}
		
		self::addBadKarma($player, $add);
	}
	
	public static function addBadKarma(SR_Player $player, $add)
	{
		if ($add <= 0)
		{
			return true;
		}

		$player->message(sprintf('Your character has been punished with %.02f bad_karma.', $add));
		
		$fraction = SR_PlayerVar::getVal($player, '__SLBADKARMA', 0.00);
		$fraction += $add;
		
		$abk = 0;
		while ($fraction > 1)
		{
			$abk += 1;
			$fraction -= 1;
		}
		if ($abk > 1)
		{
			$bk = $player->getBase('bad_karma');
			$player->saveBase('bad_karma', $bk+$abk);
			$player->message(sprintf('Your character has been punished with %s bad_karma.', $abk));
		}
	}
}
?>
