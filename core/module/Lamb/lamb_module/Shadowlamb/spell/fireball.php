<?php
final class Spell_fireball extends SR_CombatSpell
{
	public function getSpellLevel() { return 2; }
	public function getHelp() { return 'Cast a fireball into the enemies. Does moderate area damage.'; }
	public function getRequirements() { return array('firebolt'=>2,'goliath'=>1); }
	public function getCastTime($level) { return Common::clamp(40-$level, 30, 42); }
	public function getManaCost(SR_Player $player, $level)
	{
		return 1 + ($level);
	}
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		echo "Casting Fireball with level $level and $hits hits.\n";
		$this->announceADV($player, $target, $level);
		
		$inaccuracy = Common::clamp(8-$level, 1);
		$targets = SR_Grenade::computeDistances($target, $inaccuracy);
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		
		# Firebolt ads 0.20 per level
		$firebolt = $player->getSpell('firebolt');
		$firebolt = $firebolt === false ? 0 : $firebolt->getLevel($player);
		$firebolt = round($firebolt/5, 1);
		$level += $firebolt;
		
		$damage = array();
		foreach ($targets as $data)
		{
			list($pid, $d) = $data;
			$target = $ep->getMemberByPID($pid);
			$d = Common::clamp($d, 1);
			
			$hits = $this->dice($player, $target, $level); # Dice hits
			echo "!! Fireball hits=$hits, Distance=$d";
			
// 			$hits /= 2; # We take half..
// 			$hits /= ($d * 5); # And divide by distance
// 			$hits = round($hits, 1);
// 			echo " Fireball hits=$hits\n";
			
			$min = $level*1.0; # The min damage is still like 2 or 20
			$max = $min + $hits*1.9; # The max damage is min + hits 

			$dmg = Shadowfunc::diceFloat($min, $max);
			$dmg /= $d*1.35; # Apply area reduction
			$dmg = round($dmg,1);
			
			$damage[$pid] = $dmg;
		}
		
		$this->spellDamageMultiTargets($player, $damage, $level);
		
		return true;
	}
}
?>