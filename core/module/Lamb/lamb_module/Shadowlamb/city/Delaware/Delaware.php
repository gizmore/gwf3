<?php
final class Delaware extends SR_City
{
	public function getImportNPCS() { return array('Redmond_Ork','Redmond_Ueberpunk','Seattle_Cop','Seattle_Ninja'); }
	public function getArriveText() { return 'You arrive in Delaware. Meanwhile it\'s known for it\'s automobile industry.'; }
	public function getSquareKM() { return 12; }
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