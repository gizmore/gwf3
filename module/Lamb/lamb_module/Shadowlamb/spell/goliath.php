<?php
final class Spell_goliath extends SR_SupportSpell
{
	public function getHelp() { return 'Temporarily raises the strength of a friendly target.'; }
	
	public function getRequirements() { return array('magic'=>2); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return ($level/2) + 1;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$wis = $player->getWisdom() * 30;
		$dur = round($hits * 8.2) + rand(-15, 15) + rand(0, $wis);
		$by = round(sqrt($hits)/4, 2);
		$mod = array('strength'=>$by);
		$target->addEffects(new SR_Effect($dur, $mod));
		$append = sprintf('+%s strength for %s.', $by, GWF_Time::humanDuration($dur));
		$this->announceADV($player, $target, $level, $append);
		return true;
	}
//	public function cast(SR_Player $player, $args)
//	{
//		if (false === ($target = $this->getTarget($player, $args))) {
//			return false;
//		}
//		
//		$level = $this->getLevel($player);
//		$wis = $player->get('wisdom');
//		$int = $player->get('intelligence');
//		
//		$by = round((1 + $level/4 + $int/4)/2, 1);
//		
//		$dur = 120 + $level * 30 + $wis * 15 - round(0, 30);
//		
//		$str = array('strength' => $by);
//		$target->addEffects(new SR_Effect($dur, $str), new SR_Effect(round($dur/2), $str));
//		
//		# Announce
//		$msg = sprintf(' casts goliath on %s. %s strength +%s', $target->getName(), GWF_Time::humanDuration($dur), $by*2);
//		$player->getParty()->message($player, $msg);
//		$target->getParty()->message($player, $msg);
//		
//		return true;
//	}
}
?>