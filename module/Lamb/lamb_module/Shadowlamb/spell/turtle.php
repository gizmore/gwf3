<?php
final class Spell_turtle extends SR_Spell
{
	public function isOffensive() { return false; }
	
	public function getHelp(SR_Player $player) { return 'Temporarily increases the melee- and fireweapon armor of a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>4); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return $level + 6;
	}

	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		return true;
	}
	
//	public function cast_spell(Player $player, Player $target, $in_combat)
//	{
//		$by = floor($this->level / 3) + 1;
//		$time = $this->get_support_spell_time($player, $target);
//		new Effect( $target, "marm", $by, $time, 0);
//		new Effect( $target, "farm", $by, $time, 0);
//		
//		$tname = $target->get_name();
//		$msg = "cast $this->name on $tname ($time seconds marm/farm +$by).";
//		$this->announce_B($player, $target, $msg);
//	}
}

?>
