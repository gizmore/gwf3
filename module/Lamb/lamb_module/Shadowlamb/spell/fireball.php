<?php
final class Spell_fireball extends SR_Spell
{
	public function isOffensive() { return true; }
	
	public function getHelp(SR_Player $player) { return 'Cast a fireball into the enemies. Does moderate area damage.'; }
	
	public function getRequirements() { return array('firebolt'=>2,'goliath'=>1); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return 6 + ($level*2);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		return true;
	}
}
?>