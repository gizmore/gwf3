<?php
final class Chicago_Blackmarket extends SR_Store
{
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('SamuraiSword', 40.0, 4000),
			array('NinjaSword', 0.0, 8000),
			array('WoodNunchaku', 70.0, 800),
			array('Flashbang', 60.0, 1500),
//			array('FragGrenade', 2.0, 3000),
			array('Fichetti', 50.0, 4000),
			array('RugerWarhawk', 35.0, 5000),
			array('T250Shotgun', 20.0, 10000),
			array('Uzi', 15.0, 30000),
			array('KevlarVest', 15.0, 50000),
			array('ChainMail', 30.0, 25000),
			array('CloakedVest', 6.0, 60000),
			array('LightBodyArmor', -5.0, 100000),
			array('FullBodyArmor', -10.0, 300000),
			array('CombatHelmet', 16.0, 75000),
			array('M16', 16.0, 55000),
			array('Challenger', 12.0, 95000),
			array('Microgun', 8.0, 125000),
		);
	}
	public function getFoundPercentage()  { return 15; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Chicago_BMGuy'); }
	public function isPVP() { return true; }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
	
	public function onEnter(SR_Player $player)
	{
		$p = $player->getParty();
		$names = array();
		foreach ($p->getMembers() as $member)
		{
			if (!$member->hasConst('SEATTLE_BM'))
			{
				$names[] = $member->getName();
			}
		}
		
		if (count($names) === 0)
		{
			return parent::onEnter($player);
		}
		
		$this->partyMessage($player, 'oops', array(GWF_Array::implodeHuman($names)));
		return false;
	}
}
?>
