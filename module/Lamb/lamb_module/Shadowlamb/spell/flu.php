<?php
final class Spell_flu extends SR_Spell
{
	public function isOffensive() { return true; }
	
	public function getHelp(SR_Player $player) { return sprintf('Weaken an enemy.'); }
	
	public function getRequirements() { return array('magic'=>2); }
	
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