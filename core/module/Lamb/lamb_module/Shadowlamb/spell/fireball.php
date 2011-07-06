<?php
final class Spell_fireball extends SR_CombatSpell
{
	public function getSpellLevel() { return 2; }
	public function getHelp() { return 'Cast a fireball into the enemies. Does moderate area damage.'; }
	public function getRequirements() { return array('firebolt'=>2,'goliath'=>1); }
	public function getCastTime($level) { return Common::clamp(40-$level, 30, 42); }
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return 6 + ($level*2);
	}
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		echo "Casting Fireball with level $level and $hits hits.\n";
		$this->announceADV($player, $target, $level);
		
		$inaccuracy = Common::clamp(8-$level, 1);
		$targets = SR_Grenade::computeDistances($target, $inaccuracy);
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		
		$firebolt = $player->getSpell('firebolt');
		$level += $firebolt === false ? 0 : $firebolt->getLevel($player);
		
		$damage = array();
		foreach ($targets as $data)
		{
			list($pid, $d) = $data;
			$d = Common::clamp($d, 1);
			$target = $ep->getMemberByPID($pid);
			$hits = $this->dice($player, $target, $level);# * $level / 2;
			echo "Fireball hits=$hits, Distance=$d";
			$hits /= $d;
			echo "Fireball hits=$hits";
			$min = $level*2;
			$max = $level*4 + $hits;
			$dmg = rand($min*10, $max*10+$hits);
			$dmg /= 10;
			$damage[$pid] = $dmg;
		}
		
		$this->spellDamageMultiTargets($player, $damage, $level);
		
		return true;
	}
}
?>