<?php
final class Spell_chameleon extends SR_SupportSpell
{
	public function isOffensive() { return false; }
	
	public function getHelp() { return 'Temporarily increases the charisma of a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>2); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player, $level)
	{
//		$level = $this->getLevel($player);
		return (($level+2)/2) + 1;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$dur = $this->getSpellDuration($player, $target, $level, $hits);
		$by = $this->getSpellIncrement($player, $target, $level, $hits);
		$mod = array('charisma'=>$by);
		$target->addEffects(new SR_Effect($dur, $mod));
		$this->announceADV($player, $target, $level, sprintf('+%s charisma for %s.', $by, GWF_Time::humanDuration($dur)));
		return true;
	}
}

?>
