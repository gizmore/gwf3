<?php
final class Spell_firebolt extends SR_Spell
{
	public function isOffensive() { return true; }
	
	public function getHelp(SR_Player $player) { return 'Cast a firebolt against an enemy. Does some damage.'; }
	
	public function getRequirements() { return array('magic'=>2); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return 4 + ($level*1);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		return true;
	}
}
?>