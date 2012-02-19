<?php
final class Spell_calm extends SR_HealSpell
{
	public function getSpellLevel() { return 1; }
	
	public function getHelp() { return 'Slowly heal a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>1); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player, $level)
	{
//		$level = $this->getLevel($player);
		return ($level * 0.5) + 2.5;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
		$wis = $potion_player->get('wisdom');
		$int = $potion_player->get('intelligence');
		$min = $wis / 2 + $level;
		$max = $min + $int * 2 + 2;
		$amount = Shadowfunc::diceFloat($min, $max, 1) / 2;
		$seconds = Common::clamp(300-$hits, 30, 300);
		$per_sec = round($amount / $seconds, 2);
		echo "Cast calm with amount=$amount and seconds=$seconds and per_sec=$per_sec\n";
		$mod = array('hp' => $per_sec);
		$target->addEffects(new SR_Effect($seconds, $mod, SR_Effect::MODE_REPEAT));
		$this->announceADV($player, $target, $level, '10120', $per_sec, $seconds);
		return true;
	}
}
?>