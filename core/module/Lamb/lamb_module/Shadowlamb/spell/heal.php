<?php
final class Spell_heal extends SR_HealSpell
{
	public function getSpellLevel() { return 2; }
	public function getHelp() { return 'Heals a friendly target.'; }
	public function getRequirements() { return array('magic'=>4,'calm'=>2); }
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	public function getManaCost(SR_Player $player, $level)
	{
		return 6 + $level;
	}
	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
		$min = $level + 1;
		$max = $min + ($level/4) + ($hits/10);
		$gain = Shadowfunc::diceFloat($min, $max);
		$oldhp = $target->getHP();
		$maxhp = $target->getMaxHP();
		$append = Shadowfunc::displayHPGain($oldhp, $gain, $maxhp);
		$target->healHP($gain);
		$this->announceADV($player, $target, $level, '10110', $append);
		return true;
	}
}
?>