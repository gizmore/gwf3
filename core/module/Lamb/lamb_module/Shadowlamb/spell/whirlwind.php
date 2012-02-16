<?php
final class Spell_whirlwind extends SR_OffensiveSpell
{
	public function getSpellLevel() { return 2; }
	public function isOffensive() { return true; }
	public function getHelp() { return 'Blow a party away to increase their distances.'; }
	public function getCastTime($level) { return 50; }
	public function getRequirements() { return array('magic'=>4,'blow'=>2); }
	public function getRange() { return 8.0; }
	public function getManaCost(SR_Player $player, $level)
	{
		return 7 + $level;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
		
	}	
	
}
?>