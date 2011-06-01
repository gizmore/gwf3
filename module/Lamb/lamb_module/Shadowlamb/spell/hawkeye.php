<?php
final class Spell_hawkeye extends SR_SupportSpell
{
	public function getHelp() { return 'Will raise the firearms skill for a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>3); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return (($level+2)/2) + 1;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$wis = $player->getWisdom() * 30;
		$dur = round($hits * 8.2) + rand(-15, 15) + rand(0, $wis);
		$by = round(sqrt($hits)/4, 2);
		$mod = array('firearms'=>$by);
		$target->addEffects(new SR_Effect($dur, $mod));
		$this->announceADV($player, $target, $level, sprintf('+%s firearms for %s.', $by, GWF_Time::humanDuration($dur)));
		return true;
	}
}
?>
