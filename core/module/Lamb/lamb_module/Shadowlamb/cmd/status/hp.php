<?php
class Shadowcmd_hp extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return self::onHPMP($player, 'hp', '5050');
	}

	#############
	### HP/MP ###
	#############
	protected static function onHPMP(SR_Player $player, $what, $key)
	{
//		$i = 1;
		$b = chr(2);
// 		$bot = Shadowrap::instance($player);
		$party = $player->getParty();
		$members = $party->getMembers();
		$format = $player->lang('fmt_hp_mp');
		$back = '';
		foreach ($members as $member)
		{
			$member instanceof SR_Player;
			$hpmp = $member->getBase($what);
			$hpmmpm = $member->get('max_'.$what);
			$b2 = '';
			$b1 = 0;
			if ($what === 'hp')
			{
				if ($member->needsHeal())
				{
					$b2 = $b;
					$b1 = 1;
				}
			}
			elseif ($what === 'mp')
			{
				if ($member->getBase('magic') >= 0)
				{
					if ($member->needsEther())
					{
						$b2 = $b;
						$b1 = 1;
					}
				}
			}
			$back .= sprintf($format, $member->getEnum(), $member->getName(), $hpmp, $hpmmpm, $b2, $b1);
// 			$back .= sprintf(", %s-%s%s(%s/%s)%s", $b.($member->getEnum()).$b, $b2, $member->getName(), $hpmp, $hpmmpm, $b2);
		}
		
		return self::rply($player, $key, array(ltrim($back, ',; ')));
		
// 		$bot->reply(sprintf('Your parties %s: %s.', $text, substr($back, 2)));
// 		return true;
	}
}
?>
