<?php
final class Spell_firebolt extends SR_CombatSpell
{
	public function getSpellLevel() { return 1; }
	
	public function getHelp() { return 'Cast a firebolt against an enemy. Does some damage.'; }
	
	public function getRequirements() { return array('magic'=>2); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player, $level)
	{
		return 1 + ($level*0.5);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
//		echo "Casting Firebolt with level $level and $hits hits.\n";
		$min = 1.00 + $level*0.2;
		$max = $min + $level*1.0 + $hits*0.30;
		$damage = Shadowfunc::diceFloat($min, $max);
		return $this->spellDamageSingleTarget($player, $target, $level, '10040', $damage);
	}
}
?>