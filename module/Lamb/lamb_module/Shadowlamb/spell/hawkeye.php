<?php
final class Spell_hawkeye extends SR_Spell
{
	public function isOffensive() { return false; }
	
	public function getHelp(SR_Player $player) { return 'Will raise the firearms skill for a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>3); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return (($level+2)/2) + 1;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$dur = round($hits * 8.2) + rand(-15, 15);
		$by = round(sqrt($hits)/4, 2);
		$mod = array('firearms'=>$by);
		$target->addEffects(new SR_Effect($dur, $mod));
		$this->announceADV($player, $target, $level, sprintf('+%s firearms for %s.', $by, GWF_Time::humanDurationEN($dur)));
		return true;
	}
	//	public function cast_spell(Player $player, Player $target, $in_combat)
//	{
//		$by = ceil($this->level / 3) + 1;
//		$time = $this->get_support_spell_time($player, $target);
//		new Effect( $target, "firearms", $by, $time, 0);
//		$tname = $target->get_name();
//		$msg = "cast $this->name on $tname ($time seconds firearms +$by).";
//		$this->announce_B($player, $target, $msg);
//	}

}

?>
