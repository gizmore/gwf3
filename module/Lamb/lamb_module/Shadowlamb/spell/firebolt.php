<?php
final class Spell_firebolt extends SR_CombatSpell
{
	public function getHelp() { return 'Cast a firebolt against an enemy. Does some damage.'; }
	
	public function getRequirements() { return array('magic'=>2); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return 4 + ($level*0.5);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		echo "Casting Firebolt with level $level and $hits hits.\n";
		$min = $level;
		$max = $level+rand(0,2)+$hits/10;
		$damage = rand($min*10, $max*10);
		$damage /= 10;
		return $this->spellDamageSingleTarget($player, $target, $level, $damage);
	}
}
?>