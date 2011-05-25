<?php
final class Spell_hummingbird extends SR_SupportSpell
{
	public function isOffensive() { return false; }
	
	public function getHelp(SR_Player $player) { return 'Temporarily increases the quickness of a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>4); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return (($level+2)/2) + 1;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$dur = round($hits * 8.2) + rand(-15, 15) + rand(0, $player->get('wisdom')*30);
		$by = round(sqrt($hits)/4, 2);
		$mod = array('quickness'=>$by);
		$target->addEffects(new SR_Effect($dur, $mod));
		$this->announceADV($player, $target, $level, sprintf('+%s quickness for %s.', $by, GWF_Time::humanDurationEN($dur)));
		return true;
	}
}

?>
