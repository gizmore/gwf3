<?php
final class Spell_freeze extends SR_Spell
{
	public function isOffensive() { return true; }
	public function getHelp(SR_Player $player) { return "Freezes an enemy for some time"; }
	public function getRequirements() { return array('magic'=>3); }
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return 6 + $level;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		return true;
	}
	//	public function cast_spell(Player $player, Player $target, $in_combat)
//	{
//		$tname = $target->get_name();
//		$time = rand(60, 240 + 60 * $this->level);
//		$target->busy($time, 0);
//		$msg = "cast Freeze on $tname ($time seconds frozen).";
//		$this->announce_B($player, $target, $msg);
//	}
}

?>
