<?php
final class Amerindian extends SR_City
{
//	public function getImportNPCS() { return array('Redmond_Cyberpunk','Redmond_Ork','Redmond_Ueberpunk','Redmond_Burglar'); }
	public function getArriveText() { return 'You arrive at the outer Amerindian territory. A broad land and quite a few buildings. You wonder if there is a casino.'; }
	public function getSquareKM() { return 8; }
//	public function onEvents(SR_Party $party)
//	{
//		$this->onEventWallet($party);
//		return false;
//	}
//	
//	public function onEventWallet(SR_Party $party)
//	{
//		foreach ($party->getMembers() as $member)
//		{
//			$member instanceof SR_Player;
//			if ($member->isHuman())
//			{
//				$percent = 0.05;
//				$luck = $member->get('luck');
//				$percent += $luck / 200;
//				if (Shadowfunc::dicePercent($percent))
//				{
//					$nuyen = rand(10, 60);
//					$member->message(sprintf('You found a wallet with %s in it.', Shadowfunc::displayNuyen($nuyen)));
//					$member->giveNuyen($nuyen);
//				}
//			}
//		}
//	}
}
?>