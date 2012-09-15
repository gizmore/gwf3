<?php
final class Spell_calm extends SR_HealSpell
{
	public function getSpellLevel() { return 1; }
	
	public function getHelp() { return 'Slowly heal a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>1); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player, $level)
	{
		return ($level * 0.2) + 2.5;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
// 		$wis = $potion_player->get('wisdom');
// 		$int = $potion_player->get('intelligence');
		
// 		$min = $wis * 0.5 + $level * 0.5 + 1; # min hp gain
// 		$max = $min + $wis * 1.0; # max hp gain
// 		$amount = Shadowfunc::diceFloat($min, $max, 1); # amount gain
		
// 		$seconds = Common::clamp(300-$hits, 30, 300);

// 		$per_sec = round($amount / $seconds, 2);
// 		echo "Cast calm with amount=$amount and seconds=$seconds and per_sec=$per_sec\n";

		$wis = $potion_player->get('wisdom');
		
		$maxhits = 1400;
		$hits = Common::clamp($hits, 1, $maxhits);
		$per_sec = round($hits/$maxhits, 2);
		$per_sec = Common::clamp($per_sec, 0.01);
		$minsec = round($wis*10 + $hits);
		$seconds = rand($minsec, $minsec*2);
		
		$target->addEffects(new SR_Effect($seconds, array('hp' => $per_sec), SR_Effect::MODE_REPEAT));
		$this->announceADV($player, $target, $level, '10120', $per_sec, $seconds);
		return true;
	}
}
?>