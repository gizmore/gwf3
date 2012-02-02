<?php
/**
 * The freeze spell will make a target busy.
 * @author gizmore
 *
 */
final class Spell_freeze extends SR_CombatSpell
{
	public function getSpellLevel() { return 3; }
	public function getHelp() { return "Freezes an enemy for some time"; }
	public function getRequirements() { return array('magic'=>3); }
	public function getCastTime($level) { return Common::clamp(20-$level, 10, 40); }
	public function getManaCost(SR_Player $player, $level)
	{
//		$level = $this->getLevel($player);
		return 6 + $level;
	}


//	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
//	{
//		$wis = $player->get('wisdom') * 30;
//		$min = 20+$level*10;
//		$max = 40+$level*20+$wis;
//		$seconds = rand($min, $max);
//		$target->busy($seconds);
//		$append = $append_ep = sprintf('%s seconds frozen.', $seconds);
//		$this->announceADV($player, $target, $level, $append, $append_ep);
//		return true;
//	}

	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$wis = $player->get('wisdom') * 30;
		$min = 20+$level*10;
		$max = 40+$level*20+$wis;
		$seconds = rand($min, $max);
		$ef = Shadowfunc::diceFloat(0.0, $level, 1) + 1.0;
		$target->busy($ef*10);
		$effect = new SR_Effect($seconds, array('frozen'=>$ef), SR_Effect::MODE_ONCE_EXTEND);
		$target->addEffects($effect);
// 		$append = $append_ep = sprintf('%s seconds frozen with power %01f.', $seconds, $ef);
// 		$this->announceADV($player, $target, $level, $append, $append_ep);
		$this->announceADV($player, $target, $level, '10050', $seconds, $ef);
		return true;
	}
}

?>
