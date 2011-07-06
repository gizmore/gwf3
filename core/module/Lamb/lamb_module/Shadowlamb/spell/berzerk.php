<?php
final class Spell_berzerk extends SR_SupportSpell
{
	public function getSpellLevel() { return 2; }
	
	public function getHelp() { return 'Temporarily raises the min- and max_dmg for a friendly target.'; }
	public function getRequirements() { return array('magic'=>3); }
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return (($level+3)/2) + 1;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$dur = $this->getSpellDuration($player, $target, $level, $hits);
		$by = $this->getSpellIncrement($player, $target, $level, $hits);
		$mod = array('min_dmg'=>$by, 'max_dmg'=>$by*2);
		$target->addEffects(new SR_Effect($dur, $mod));
		$append = sprintf('+%s min_dmg / +%s max_dmg for %s.', $by, $by*2, GWF_Time::humanDuration($dur));
		$this->announceADV($player, $target, $level, $append, '');
		return true;
	}
}
?>
