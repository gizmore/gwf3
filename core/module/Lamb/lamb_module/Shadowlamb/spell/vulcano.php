<?php
final class Spell_vulcano extends SR_CombatSpell
{
	public function getSpellLevel() { return 4; }
	
	public function getHelp() { return 'Cast a huge fireball into the enemy party. Does big party damage.'; }
	
	public function getRequirements() { return array('magic'=>2, 'firewall'=>5); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player, $level)
	{
		return 5 + ($level*2);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		echo "Casting Vulcano with level $level and $hits hits.\n";
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
		# Fireball ads 0.25 per level
		$fireball = $player->getSpell('fireball');
		$fireball = $fireball === false ? 0 : $fireball->getLevel($player);
		$fireball = round($fireball/4, 1);
		$level += $fireball;
		# Firewall ads 0.3 per level
		$firewall = $player->getSpell('firewall');
		$firewall = $firewall === false ? 0 : $firewall->getLevel($player);
		$firewall = round($firewall*0.3, 1);
		$level += $firewall;
		
		$damage = array();
		foreach ($targets as $data)
		{
			list($pid, $d) = $data;
			$target = $ep->getMemberByPID($pid);
			$d = Common::clamp($d, 2);
		
			$hits = $this->dice($player, $target, $level); # Dice hits
			echo "!! Vulcano hits=$hits, Distance=$d";
		
			$min = $level*2; # The min damage is still like 2 or 20
			$max = $min*1.5 + $hits; # The max damage is min + hits 

			$dmg = Shadowf1unc::diceFloat($min, $max);
			$dmg /= $d*2.0;
		
			$damage[$pid] = $dmg;
		}
		
		$this->spellDamageMultiTargets($player, $damage, $level);
		
		return true;
	}
}
?>