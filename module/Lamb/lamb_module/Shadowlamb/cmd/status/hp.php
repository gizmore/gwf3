<?php
class Shadowcmd_hp extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return self::onHPMP($player, 'hp', 'HP');
	}

	#############
	### HP/MP ###
	#############
	protected static function onHPMP(SR_Player $player, $what, $text)
	{
		$i = 1;
		$b = chr(2);
		$bot = Shadowrap::instance($player);
		$party = $player->getParty();
		$members = $party->getMembers();
		$back = '';
		foreach ($members as $member)
		{
			$member instanceof SR_Player;
			$hpmp = $member->getBase($what);
			$hpmmpm = $member->get('max_'.$what);
			$b2 = '';
			if ($what === 'hp')
			{
				if ($member->needsHeal()) {
					$b2 = $b;
				}
			}
			elseif ($what === 'mp')
			{
				if ($member->needsEther())
				{
					$b2 = $b;
				}
			}
			$back .= sprintf(", %s-%s%s(%s/%s)%s", $b.($i++).$b, $b2, $member->getName(), $hpmp, $hpmmpm, $b2);
		}
		$bot->reply(sprintf('Your parties %s: %s.', $text, substr($back, 2)));
		return true;
	}
}
?>
