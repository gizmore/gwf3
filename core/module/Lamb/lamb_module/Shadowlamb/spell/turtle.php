<?php
final class Spell_turtle extends SR_SupportSpell
{
	public function getSpellLevel() { return 2; }
	
	public function isOffensive() { return false; }
	
	public function getHelp() { return 'Temporarily increases the melee- and fireweapon armor of a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>4); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player, $level)
	{
//		$level = $this->getLevel($player);
		return $level + 6;
	}

	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$dur = $this->getSpellDuration($player, $target, $level, $hits);
		$by = $this->getSpellIncrement($player, $target, $level, $hits);
		$mod = array('marm'=>$by, 'farm'=>$by);
		$target->addEffects(new SR_Effect($dur, $mod));
		$append = sprintf('+%s marm/farm for %s.', $by, GWF_Time::humanDuration($dur));
		$this->announceADV($player, $target, $level, $append);
		return true;
	}
}
?>
