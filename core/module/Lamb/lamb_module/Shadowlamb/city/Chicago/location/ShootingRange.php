<?php
final class Chicago_ShootingRange extends SR_School
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Chicago_Shooter'); }
	
	public function getFoundPercentage() { return 60.00; }
	public function getFoundText(SR_Player $player) { return 'You found an interesting building: "El monnino School of Rangers".'; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "Use {$c}learn <course> to learn a new skill. See an overview of the skills to learn with {$c}courses. Use {$c}talk <word> to talk to the ranger.";}
	
	public function onEnter(SR_Player $player)
	{
		$p = $player->getParty();
		$p->notice('You enter the school and walk to the training range. You see a dwarf in heavy armor watching the excercises."');
		return parent::onEnter($player);
	}
	
	public function getFields(SR_Player $player)
	{
		return array(
			array('firearms', 250),
			array('bows', 350),
			array('pistols', 450),
			array('shotguns', 600),
			array('smgs', 900),
			array('hmgs', 1800),
			array('sharpshooter', 1300),
		);
	}
}
?>
