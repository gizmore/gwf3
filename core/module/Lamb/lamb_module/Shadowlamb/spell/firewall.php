<?php
final class Spell_firewall extends SR_CombatSpell
{
	public function getSpellLevel() { return 3; }
	
	public function getHelp() { return 'Cast a firebolt against a line of enemies. Does some damage.'; }
	
	public function getRequirements() { return array('fireball'=>2); }
	
	public function getCastTime($level) { return Common::clamp(50-$level, 40, 52); }
	
	public function getManaCost(SR_Player $player, $level)
	{
		return 4 + ($level);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
// 		echo "Casting Firewall with level $level and $hits hits.\n";
		
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
				$hits = $this->dice($player, $t, $l);
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
		$max = $min + $hits * 0.4;
		return Shadowfunc::diceFloat($min, $max);
	}
}
?>