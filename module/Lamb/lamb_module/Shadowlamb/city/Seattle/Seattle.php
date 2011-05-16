<?php
final class Seattle extends SR_City
{
	public function getArriveText() { return 'You arrive at Seattle. It is a big city with a bunch of slums and a big commercial centrum.'; }
	public function getSquareKM() { return 8; }
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