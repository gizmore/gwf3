<?php
final class Spell_calm extends SR_HealSpell
{
	public function getHelp() { return 'Slowly heal a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>1); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return ($level * 0.5) + 2.5;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$wis = $player->get('wisdom') + 1;
		$amount = $level + rand(0, $wis);
		$seconds = Common::clamp(90-$hits, 30, 90);
		$per_sec = round($amount / $seconds, 2);
		echo "Cast calm with amount=$amount and seconds=$seconds and per_sec=$per_sec\n";
		$mod = array('hp' => $per_sec);
		$target->addEffects(new SR_Effect($seconds, $mod, SR_Effect::MODE_REPEAT));
		$this->announceADV($player, $target, $level);
		return true;
	}
}
?>