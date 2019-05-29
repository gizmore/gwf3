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
			if (!$e->isHuman()) # Friendly NPC
			{
				$add += 0.05;
				continue;
			}
			
			
			$badkarma = $e->getBase('bad_karma');
			if ($badkarma > 1.0)
			{
				continue; # Attack Badboy is ok			}
			}
			
			# Fighting others is 0.1
			$add += 0.1;

			
//			$bounty = $e->getBase('sr4pl_bounty');

// 			$l2 = $e->get('level');
// 			$diff = $l1 - $l2;
// 			if ($diff < 0)
// 			{
// 				continue; # May attack higher player? Hmm..
// 			}
			
// 			$add += round($diff / 10, 2);
		}
		
		# And add it!
		self::addBadKarma($player, $add);
	}
	
	public static function onKilled(SR_Player $killer, SR_Player $target)
	{
		$add = 0;
		if ($target instanceof SR_TalkingNPC)
		{
			$add += 0.25;
		}
		
		if ($target->isHuman())
		{
			$add += 0.90;
		}

		# And add it!
		self::addBadKarma($killer, $add);
	}
	
	
	/**
	 * Distribute bad karma to a player. Announce to him too.
	 * @param SR_Player $player
	 * @param float $add
	 * @return true|false
	 */
	public static function addBadKarma(SR_Player $player, $add)
	{
		$add = round($add, 2);
		
		# Sane?
		if ($add <= 0)
		{
			return true; # nothing to add
		}
		

		# Get fraction
		$fraction = SR_PlayerVar::getVal($player, '__SLBADKARMA', 0.00);
		
		# Add more
		$fraction += $add;
		
		# To ints
		$abk = (int)$fraction;
		$fraction -= $abk;

		# Full int?
		if ($abk >= 1)
		{
			# Save new int bad karma
			$bk = $player->getBase('bad_karma');
			$player->saveBase('bad_karma', $bk+$abk);
		}
		
		# Announce
		$player->msg('5036', array($add));
// 		$player->message(sprintf('Your character has been punished with %s bad_karma.', $abk+$fraction));
		
		# Save fraction
		return SR_PlayerVar::setVal($player, '__SLBADKARMA', round($fraction, 2));
	}
	
	public static function displayBadKarmaParty(SR_Party $party)
	{
		$back = '';
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$bk = $member->getBase('bad_karma');
			if ($bk > 0)
			{
				$back .= Shadowrun4::lang('info_bk', array($member->getName(), $bk));
// 				$back .= sprintf(', %s has %d bad_karma', $member->getName(), $bk);
			}
		}
		
		return $back === '' ? '' : sprintf(' %s.', substr($back, 2));
	}
}
?>
