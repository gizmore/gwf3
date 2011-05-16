<?php
final class Spell_blow extends SR_Spell
{
	public function isOffensive() { return true; }
	public function getHelp(SR_Player $player) { return 'Blow an enemy away to increase his distance.'; }
	public function getCastTime($level) { return 45; }
	public function getRequirements() { return array('magic'=>2); }
	public function getManaCost(SR_Player $player)
	{
		return 4 + $this->getLevel($player);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		
	}	
}
?>