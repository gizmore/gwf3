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
		return $level + 6;
	}

	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
		$dur = $this->getSpellDuration($potion_player, $target, $level, $hits);
		$by = $this->getSpellIncrement($potion_player, $target, $level, $hits);
		$by = $this->lowerSpellIncrement($target, $by, 'marm');
		$mod = array('marm'=>$by, 'farm'=>$by);
		$target->addEffects(new SR_Effect($dur, $mod));
// 		$append = sprintf('+%s marm/farm for %s.', $by, GWF_Time::humanDuration($dur));
		$this->announceADV($player, $target, $level, '10100', $by, GWF_Time::humanDuration($dur));
		return true;
	}
}
?>
