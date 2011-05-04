<?php
final class Spell_hummingbird extends SR_Spell
{
	public function isOffensive() { return false; }
	
	public function getHelp(SR_Player $player) { return 'Temporarily increases the quickness of a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>4); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return (($level+2)/2) + 1;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$dur = round($hits * 8.2) + rand(-15, 15);
		$by = round(sqrt($hits)/4, 2);
		$mod = array('quickness'=>$by);
		$target->addEffects(new SR_Effect($dur, $mod));
		$this->announceADV($player, $target, $level, sprintf('+%s quickness for %s.', $by, GWF_Time::humanDurationEN($dur)));
		return true;
	}
	
//	public function cast_spell(Player $player, Player $target, $in_combat)
//	{
//		$by = ceil($this->level / 2) + 1;
//		$time = $this->get_support_spell_time($player, $target);
//		new Effect( $target, "quickness", $by, $time, 0);
//		
//		$tname = $target->get_name();
//		$msg = "cast $this->name on $tname ($time seconds quickness +$by).";
//		$this->announce_B($player, $target, $msg);
//	}
}

?>
