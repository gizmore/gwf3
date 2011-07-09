<?php
final class Redmond extends SR_City
{
	const TIME_TO_SEATTLE = 300;
	public function getArriveText() { return 'You arrive at Redmond. Home sweet home.'; }
	public function getSquareKM() { return 6; }
//	public function getExploreTime() { return 180; }
	
	public function onEvents(SR_Party $party)
	{
		$this->onEventWallet($party);
		return false;
	}
	
	public function onEventWallet(SR_Party $party)
	{
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			if ($member->isHuman())
			{
				$percent = 0.05;
				$luck = $member->get('luck');
				$percent += $luck / 200;
				if (Shadowfunc::dicePercent($percent))
				{
					$nuyen = rand(10, 60);
					$member->message(sprintf('You found a wallet with %s in it.', Shadowfunc::displayPrice($nuyen)));
					$member->giveNuyen($nuyen);
				}
			}
		}
	}
}
?>