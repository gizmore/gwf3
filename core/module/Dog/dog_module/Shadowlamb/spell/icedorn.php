<?php
/**
 * The freeze spell will make a target busy.
 * @author gizmore
 */
final class Spell_icedorn extends SR_OffensiveSpell
{
	public function getSpellLevel() { return 2; }
	public function getHelp() { return "Damages and slows down an enemy for some time"; }
	public function getRequirements() { return array('magic'=>3); }
	public function getCastTime($level) { return Common::clamp(25-$level, 15, 45); }
	public function getManaCost(SR_Player $player, $level)
	{
		return 6 + $level;
	}

	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
		$wis = $potion_player->get('wisdom') * 30;
		$min = 5+$level*5;
		$max = 10+$level*10+$wis;
		$seconds = rand($min, $max);
		$seconds = $this->lowerSpellIncrement($target, $seconds, 'frozen');
		$target->busy($seconds*10);
		$ef = Shadowfunc::diceFloat(0.1, $level, 1);
		$target->addEffects(new SR_Effect($seconds, array('frozen'=>$ef), SR_Effect::MODE_ONCE_EXTEND));
		
		$min = 0.50 + $level*0.3;
		$max = $min + $level*0.8 + $hits*0.25;
		$damage = Shadowfunc::diceFloat($min, $max);
		
		return $this->spellDamageSingleTarget($player, $target, $level, '10040', $damage, $seconds);
	}
}
