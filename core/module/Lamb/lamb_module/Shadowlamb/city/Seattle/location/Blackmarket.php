<?php
final class Seattle_Blackmarket extends SR_Store
{
//	const TEMP = "SEATLLE_BM_ITEMS";
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
		);
	}
	public function getFoundPercentage()  { return 15; }
	public function getFoundText(SR_Player $player) { return "You spot a suspicous place. It looks like a market, but big trolls secure the area from Lonestar officers and unwelcome pedestrians."; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_BMGuy'); }
	public function getHelpText(SR_Player $player) { return "Use #view, #buy and #sell here. The items in the Blackmarket are a bit random. Use #talk to talk to the salesman."; }
	public function isPVP() { return true; }
	public function getEnterText(SR_Player $player) { return "You enter the blackmarket. You move to a big bazzar like shop. The owner is a big Troll."; }
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
		
		if (count($names) === 0) {
			parent::onEnter($player);
			return;
		}

		$p->notice(sprintf('One of the guards come to you. Seems like %s lack(s) the permission to enter. You decide to turn around and leave.', Common::implodeHuman($names)));
	}
}
?>