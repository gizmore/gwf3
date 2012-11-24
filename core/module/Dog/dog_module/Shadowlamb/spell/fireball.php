<?php
final class Spell_fireball extends SR_OffensiveSpell
{
	public function getSpellLevel() { return 2; }
	public function getHelp() { return 'Cast a fireball into the enemies. Does moderate area damage.'; }
	public function getRequirements() { return array('firebolt'=>2,'goliath'=>1); }
	public function getCastTime($level) { return Common::clamp(40-$level, 30, 42); }
	public function getManaCost(SR_Player $player, $level)
	{
		return 2 + $level * 0.50;
	}
	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
		echo "Casting Fireball with level $level and $hits hits.\n";
		$this->announceADV($player, $target, $level);
		
		# Firebolt ads 0.20 per level
		$firebolt = $potion_player->getSpell('firebolt');
		$firebolt = $firebolt === false ? 0 : $firebolt->getLevel($potion_player);
		$firebolt = round($firebolt/5, 1);
		$level += $firebolt;
		
		# Inaccuracy
		$inaccuracy = Common::clamp(4-$level*0.15, 1);
		$targets = SR_Grenade::computeDistances($target, $inaccuracy);
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		
		$damage = array();
		foreach ($targets as $data)
		{
			list($pid, $d) = $data;
			$target = $ep->getMemberByPID($pid);
			$d = Common::clamp($d, 1);
			
			$hits = $this->dice($potion_player, $target, $level); # Dice hits
			
			echo "!! Fireball hits=$hits, Distance=$d\n";
			
// 			$hits /= 2; # We take half..
// 			$hits /= ($d * 5); # And divide by distance
// 			$hits = round($hits, 1);
// 			echo " Fireball hits=$hits\n";
			
			$min = 1.00 + $level*0.5; # Min damage is quite low
			$max = $min + $level + $hits*0.5; # The max damage is min + hits 

			$dmg = Shadowfunc::diceFloat($min, $max);
			$dmg /= ($d/SR_Party::X_COORD_INC)*1.40; # Apply area reduction
			$dmg = round($dmg,1);
			
// 			$player->message(sprintf("You have hit %s with %d hits, your damage is %.02f-%.02f, Distance from impact: %.02fm", $target->getName(), $hits, $min, $max, $d));
			
			$damage[$pid] = $dmg;
		}
		
		$this->spellDamageMultiTargets($player, $damage, $level);
		
		return true;
	}
}
?>