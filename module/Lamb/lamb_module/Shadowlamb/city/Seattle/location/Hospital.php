<?php
final class Seattle_Hospital extends SR_Hospital
{
	public function getHealPrice() { return 120; }
	
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_Doctor'); }
	public function getFoundPercentage() { return 85.00; }
	public function getFoundText(SR_Player $player) { return 'You found the Seattle Hospital. A sign reads: Renraku Cyberware 20% off. As if we didn\'t know.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the huge building and are guided to a doctor.'; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "Use {$c}talk <topic> to talk to the doctor. Use {$c}view, {$c}implant and {$c}unplant to manage your cyberwear. Use {$c}heal to pay some nuyen and get healed."; }
	
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Sporn'),
			array('Headcomputer'),
			array('SmartGoggles'),
			array('Cybermuscles'),
			array('CybermusclesV2'),
			array('DermalPlates'),
			array('DermalPlatesV2'),
			array('WiredReflexes'),
			array('WiredReflexesV2'),
		);
	}
}
?>