<?php
final class Spell_calm extends SR_Spell
{
	public function isOffensive() { return false; }
	
	public function getHelp(SR_Player $player) { return 'Slowly heal a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>1); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return ($level * 0.5) + 2.5;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$amount = $level;
		$seconds = Common::clamp(90-$hits, 30, 90);
		$per_sec = $amount / $seconds;
		
		echo "Cast calm with amount=$amount and seconds=$seconds and per_sec=$per_sec\n";
		
		$mod = array('hp' => $per_sec);
		$target->addEffects(new SR_Effect($seconds, $mod, SR_Effect::MODE_REPEAT));
		$this->announce($player, $target, $level);
		return true;
	}
//	public function cast(SR_Player $player, $args)
//	{
//		if (false === ($target = $this->getTarget($player, $args))) {
//			return false;
//		}
//		
//		$level = $this->getLevel($player);
//		
//		$step = 30 - ($level);
//		$duration = 120 + $level * 60;
//		$heal = round($level / 2) + 1;
//		
//		$player->addEffects(new SR_Effect($duration, array('hp'=>$heal), SR_Effect::MODE_REPEAT, $step));
//	}
	
}
?>