<?php
final class Seattle extends SR_City
{
	const TIME_TO_DELAWARE = 450;
	const TIME_TO_VEGAS = 1450;
	
	public function getImportNPCS() { return array('Redmond_Cyberpunk','Redmond_Ork','Redmond_Ueberpunk','Redmond_Burglar','Redmond_Snowman','Redmond_Lamer'); }
	public function getArriveText(SR_Player $player) { return 'You arrive at Seattle. It is a big city with a bunch of slums and a big commercial centrum.'; }
	public function getSquareKM() { return 8; }
	public function getMinLevel() { return 8; }
	
//	public function getExploreTime() { return 210; }
	public function onEvents(SR_Party $party)
	{
		$this->onEventWallet($party);
		return false;
	}
	
	public function getRespawnLocation(SR_Player $player)
	{
		if ( ($player->getNuyen() > 100) && ($player->hasKnowledge('places', 'Seattle_Hotel')) )
		{
			return 'Seattle_Hotel';
		}
		return parent::getRespawnLocation($player);
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
					$member->message(sprintf('You found a wallet with %s in it.', Shadowfunc::displayNuyen($nuyen)));
					$member->giveNuyen($nuyen);
				}
			}
		}
	}
}
?>
