<?php
final class Spell_heal extends SR_HealSpell
{
	public function getSpellLevel() { return 2; }
	public function getHelp() { return 'Heals a friendly target.'; }
	public function getRequirements() { return array('magic'=>4,'calm'=>2); }
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	public function getManaCost(SR_Player $player, $level)
	{
//		return 6 + $this->getLevel($player);
		return 6 + $level;
	}
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$min = $level + 1;
		$max = $min + ($level/4) + ($hits/10);
		$hp_gain = Shadowfunc::diceFloat($min, $max);

		
//		$hits = ($hits+$wisdom) / 10;
		
		
//		$hits = round($hits/4, 1) + $player->getBase('wisdom');
//		$min = $level + $hits;
//		$max = ($level + $hits) * intval($level / 2) + rand(0, $player->get('wisdom'));
//		$hp_gain = rand($min*10, $max*10);
//		$hp_gain /= 10;

		
		$target->healHP($hp_gain);
		$hp = $target->getHP();
		$max_hp = $target->getMaxHP();
		$append = ". ".$target->getName()." gained +{$hp_gain}({$hp}/{$max_hp})HP";
		$this->announceADV($player, $target, $level, $append);
		return true;
	}
}
?>