<?php
final class Redmond_School extends SR_School
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Redmond_jmoncayo'); }
	
	public function getFoundPercentage() { return 60.00; }
	public function getFoundText(SR_Player $player) { return 'You found an interesting building: "Jmoncayos School of Fireweapons".'; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "Use {$c}learn <course> to learn a new skill. See an overview of the skills to learn with {$c}courses. Use {$c}talk <word> to talk to the teacher.";}
	
	public function onEnter(SR_Player $player)
	{
		$p = $player->getParty();
		$p->notice('You enter the school and take a look at the billboard: "Courses: Firearms, Pistols, Shotguns, SMGs, Sharpshooter"');
		$p->notice('A teacher tips your shoulder: "Welcome. Are you here to learn a new skill? You can take a course anytime."');
		return parent::onEnter($player);
	}
	
	public function getFields(SR_Player $player)
	{
		return array(
			array('firearms', 250),
			array('pistols', 400),
			array('shotguns', 600),
			array('smgs', 900),
			array('sharpshooter', 1200),
		);
	}
}
?>
