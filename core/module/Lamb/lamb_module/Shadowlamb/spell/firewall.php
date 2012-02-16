<?php
final class Spell_firewall extends SR_OffensiveSpell
{
	public function getSpellLevel() { return 3; }
	
	public function getHelp() { return 'Cast a firebolt against a line of enemies. Does some damage.'; }
	
	public function getRequirements() { return array('fireball'=>2); }
	
	public function getCastTime($level) { return Common::clamp(50-$level, 40, 52); }
	
	public function getManaCost(SR_Player $player, $level)
	{
		return 4 + ($level*1.0);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
// 		echo "Casting Firewall with level $level and $hits hits.\n";
		
		# Firebolt ads 0.20 per level
		$firebolt = $potion_player->getSpell('firebolt');
		$firebolt = $firebolt === false ? 0 : $firebolt->getLevel($potion_player);
		$firebolt = round($firebolt/5, 1);
		$level += $firebolt;
		
		# Fireball ads 0.25 per level
		$fireball = $potion_player->getSpell('fireball');
		$fireball = $fireball === false ? 0 : $fireball->getLevel($potion_player);
		$fireball = round($fireball/4, 1);
		$level += $fireball;
		
		$line = $target->getY();
		$damage = array();
		$ep = $target->getParty();
		foreach ($ep->getMembers() as $t)
		{
			$t instanceof SR_Player;
			$d = abs($line - $t->getY());
// 			echo "Distance to target is $d\n";
			$l = $level - $d;
			if ($l >= 0)
			{
				$hits = $this->dice($potion_player, $t, $l);
				$damage[$t->getID()] = $this->calcFirewallDamage($player, $t, $level, $hits);
			}
		}

		$this->announceADV($player, $target, $level);
		Shadowfunc::multiDamage($player, $damage);
		return true;
	}
	
	private function calcFirewallDamage(SR_Player $player, SR_Player $target, $level, $hits)
	{
// 		echo "Calc damage with $hits hits\n";
		$min = $level + 1;
		$max = $min + $hits * 1.0;
		return Shadowfunc::diceFloat($min, $max);
	}
}
?>