<?php
/**
 * The freeze spell will make a target busy.
 * @author gizmore
 *
 */
final class Spell_freeze extends SR_CombatSpell
{
	public function getHelp(SR_Player $player) { return "Freezes an enemy for some time"; }
	public function getRequirements() { return array('magic'=>3); }
	public function getCastTime($level) { return Common::clamp(20-$level, 10, 40); }
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return 6 + $level;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$wis = $player->getWisdom() * 30;
		$min = 20+$level*10;
		$max = 40+$level*20+$wis;
		$seconds = rand($min, $max);
		$target->busy($seconds);
		$append = $append_ep = sprintf('%s seconds frozen.', $seconds);
		$this->announceADV($player, $target, $level, $append, $append_ep);
		return true;
	}
}

?>
