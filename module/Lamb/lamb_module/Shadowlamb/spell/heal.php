<?php
final class Spell_heal extends SR_Spell
{
	public function isOffensive() { return false; }
	
	public function getHelp(SR_Player $player) { return 'Heals a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>4,'calm'=>2); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return $level + 2;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		return true;
	}
	
}
?>