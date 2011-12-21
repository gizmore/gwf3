<?php
final class Spell_tornado extends SR_CombatSpell
{
	public function getSpellLevel() { return 3; }
	public function isOffensive() { return true; }
	public function getHelp() { return 'Blow a party far away to increase their distances.'; }
	public function getCastTime($level) { return 60; }
	public function getRequirements() { return array('magic'=>5,'whirlwind'=>3); }
	public function getRange() { return 32.0; }
	public function getManaCost(SR_Player $player, $level)
	{
		return 8 + $level * 2;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		
	}	
	
}
?>