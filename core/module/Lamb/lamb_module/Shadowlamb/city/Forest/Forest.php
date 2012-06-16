<?php
final class Forest extends SR_City
{
	public function getArriveText(SR_Player $player) { return $this->lang($player, 'arrive'); }
	public function getMinLevel() { return 21; }
	public function getSquareKM() { return 40; }
	public function getImportNPCS() { return array('Seattle_Robber', 'Redmond_Ork', 'TrollCellar_Imp', 'TrollCellar_CaveTroll', 'Vegas_Troll', 'Forest_SmallZombieBear', 'Forest_ZombieBear'); }
	
	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Seattle')->getRespawnLocation($player);
	}
	
	public function onEvents(SR_Party $party)
	{
		$this->onEventMushroom($party);
		return false;
	}
	
	private function onEventMushroom(SR_Party $party)
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
					$amt = rand(2, 4);
					$member->giveItems(array(SR_Item::createByName('Bolete', $amt)));
					$member->message($this->lang($player, 'mushrooms', array($amt)));
				}
			}
		}
	}
}
?>