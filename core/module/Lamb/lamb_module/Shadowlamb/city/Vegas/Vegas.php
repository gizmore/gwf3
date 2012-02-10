<?php
final class Vegas extends SR_City
{
	const TIME_TO_Chicago = 500;
	
	public function getImportNPCS()
	{
		return array();
	}
		
	public function getArriveText(SR_Player $player) { return $this->lang($player, 'arrive'); }
	
	public function getSquareKM() { return 14; }
	public function getMinLevel() { return 26; }
	
	public function onEvents(SR_Party $party)
	{
		$this->onEventWallet($party);
		return false;
	}
	
	public function getRespawnLocation(SR_Player $player)
	{
		if ( ($player->getNuyen() > 200) && ($player->hasKnowledge('places', 'Vegas_Hotel')) )
		{
			return 'Vegas_Hotel';
		}
		return Shadowrun4::getCity('Chicago')->getRespawnLocation($player);
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
					$nuyen = rand(100, 1000);
					$member->message(sprintf('You found a wallet with %s in it.', Shadowfunc::displayNuyen($nuyen)));
					$member->giveNuyen($nuyen);
				}
			}
		}
	}
}
?>