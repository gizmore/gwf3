<?php
final class Seattle_Blackmarket extends SR_Store
{
//	const TEMP = "SEATLLE_BM_ITEMS";
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('SamuraiSword', 80.0),
			array('Flashbang', 80.0),
			array('FragGrenade', 50.0),
			array('Fichetti', 60.0),
			array('RugerWarhawk', 45.0),
			array('T250Shotgun', 35.0),
			array('Uzi', 20.0),
			array('KevlarVest', 25.0),
			array('ChainMail', 30.0),
			array('CloakedVest', 10.0),
			array('PartBodyArmor', 0.0),
			array('FullBodyArmor', -5.0),
			array('CombatHelmet', 20.0),
		);
	}
	public function getFoundPercentage()  { return 15; }
	public function getFoundText() { return "You spot a suspicous place. It looks like a market, but big trolls secure the area from Lonestar officers and unwelcome pedestrians."; }
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