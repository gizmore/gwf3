<?php
final class Spell_berzerk extends SR_Spell
{
	public function isOffensive() { return false; }
	
	public function getHelp(SR_Player $player) { return 'Temporarily raises the min- and max_dmg for a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>3); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return (($level+3)/2) + 1;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$dur = round($hits * 8.2) + rand(-15, 15);
		$by = round(sqrt($hits)/8, 2);
		$mod = array('min_dmg'=>$by, 'max_dmg'=>$by*2);
		$target->addEffects(new SR_Effect($dur, $mod));
		$this->announceADV($player, $target, $level, sprintf('+%s min_dmg / +%s max_dmg for %s.', $by, $by*2, GWF_Time::humanDurationEN($dur)));
		return true;
	}
	
//	public function cast_spell(Player $player, Player $target, $in_combat)
//	{
//		$by = floor($this->level / 3) + 1;
//		$time = $this->get_support_spell_time($player, $target);
//		new Effect( $target, "mindmg", $by, $time, 0);
//		new Effect( $target, "maxdmg", $by*2, $time, 0);
//		$tname = $target->get_name();
//		$msg = sprintf('cast %s on %s: %d seconds mindmg+%d and maxdmg+%d.', $this->name, $tname, $time, $by, $by*2);
//		$this->announce_B($player, $target, $msg);
//	}
}

?>
