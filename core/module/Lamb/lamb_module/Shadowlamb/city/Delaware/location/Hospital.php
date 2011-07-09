<?php
final class Delaware_Hospital extends SR_Hospital
{
	public function getHealPrice() { return 250; }
	
	public function getNPCS(SR_Player $player) { return array('talk' => 'Delaware_Doctor'); }
	public function getFoundPercentage() { return 85.00; }
	public function getFoundText(SR_Player $player) { return 'You found the Delaware Hospital. A sign reads: Renraku Cyberware 20% off. As if we didn\'t know.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the huge building and are guided to a doctor.'; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "Use {$c}talk <topic> to talk to the doctor. Use {$c}view, {$c}implant and {$c}unplant to manage your cyberwear. Use {$c}heal to pay some nuyen and get healed."; }
	
	public function getStoreItems(SR_Player $player)
	{
		$back = array();
		$rep = $player->get('reputation');
		
		$back[] = array('Headcomputer');
		$back[] = array('SmartGoggles');
		$back[] = array('Cybermuscles');
		$back[] = array('CybermusclesV2');
		$back[] = array('CybermusclesV3');
		$back[] = array('DermalPlates');
		if ($rep >= 2) $back[] = array('DermalPlatesV2');
		$back[] = array('WiredReflexes');
		if ($rep >= 2) $back[] = array('WiredReflexesV2');
		$back[] = array('Sporn');
		
		return $back;
	}
}
?>