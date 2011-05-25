<?php
final class Spell_whirlwind extends SR_CombatSpell
{
	public function isOffensive() { return true; }
	public function getHelp(SR_Player $player) { return 'Blow a party away to increase their distances.'; }
	public function getCastTime($level) { return 50; }
	public function getRequirements() { return array('magic'=>4,'blow'=>2); }
	public function getDistance() { return 6.0; }
	public function getManaCost(SR_Player $player)
	{
		return 7 + $this->getLevel($player);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		
	}	
	
}
?>