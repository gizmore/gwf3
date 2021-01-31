<?php
/**
 * The freeze spell will make a target busy.
 * @author gizmore
 */
final class Spell_freeze extends SR_OffensiveSpell
{
	public function getSpellLevel() { return 3; }
	public function getHelp() { return "Freezes an enemy for some time"; }
	public function getRequirements() { return array('magic'=>3); }
	public function getCastTime($level) { return Common::clamp(20-$level, 10, 40); }
	public function getManaCost(SR_Player $player, $level)
	{
		return 6 + $level;
	}

	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
		$wis = $potion_player->get('wisdom') * 30;
		$min = 20+$level*10;
		$max = 40+$level*20+$wis;
		$seconds = rand($min, $max);
		$seconds = $this->lowerSpellIncrement($target, $seconds, 'frozen');
		$target->busy($seconds);
		$ef = Shadowfunc::diceFloat(0.1, $level, 1);
		$target->addEffects(new SR_Effect($seconds, array('frozen'=>$ef), SR_Effect::MODE_ONCE_EXTEND));
		$this->announceADV($player, $target, $level, '10050', $seconds, $ef);
		return true;
	}
}
?>
