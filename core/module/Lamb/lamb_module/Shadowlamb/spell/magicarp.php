<?php
final class Spell_magicarp extends SR_Spell
{
	public function getSpellLevel() { return 5; }
	public function getHelp() { return 'Reduce an opponents MP.'; }
	public function getRequirements() { return array('magic'=>5,'calm'=>1,'blow'=>1); }
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	public function isOffensive() { return true; }
	public function getManaCost(SR_Player $player, $level)
	{
//		$level = $this->getLevel($player);
		return 6 + ($level*0.7);
	}
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		echo "Casting ".$this->getName()." with level $level and $hits hits.\n";
		
		$min = 0.0;
		$max = $hits*1.5;
		$sucked = Shadowfunc::diceFloat($min, $max, 1);
		$target->healMP(-$sucked);
		$append = sprintf('%s lost %s MP.', $target->getName(), $sucked);
		$this->announceADV($player, $target, $level, $append);
		return true;
	}
}
?>