<?php
final class Spell_hummingbird extends SR_SupportSpell
{
	public function getSpellLevel() { return 2; }
	
	public function isOffensive() { return false; }
	
	public function getHelp() { return 'Temporarily increases the quickness of a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>4); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player, $level)
	{
//		$level = $this->getLevel($player);
		return (($level+2)/2) + 1;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
		$dur = $this->getSpellDuration($potion_player, $target, $level, $hits);
		$by = $this->getSpellIncrement($potion_player, $target, $level, $hits);
		$mod = array('quickness'=>$by);
		$target->addEffects(new SR_Effect($dur, $mod));
		$this->announceADV($player, $target, $level, '10080', $by, GWF_Time::humanDuration($dur));
		return true;
	}
}

?>
