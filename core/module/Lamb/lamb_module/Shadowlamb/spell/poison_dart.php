<?php
final class Spell_poison_dart extends SR_CombatSpell
{
	public function isOffensive() { return true; }

	public function getHelp() { return 'Poisons an enemy and does some instant damage.'; }
	
	public function getRequirements() { return array('magic'=>3); }
	
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return $level + 6;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$damage = rand($level, $level+$player->get('wisdom')+1);
		$this->spellDamageSingleTarget($player, $target, $level, $damage);

		$seconds = Common::clamp(90-$hits, 30, 90);
		$amount = rand($level*2, $level*2+$hits/3);
		$per_sec = round($amount / $seconds, 2);
		echo "Casting poison_dart with level $level and $hits hits. The target will loose $amount HP within $seconds seconds.\n";
		$modifiers = array('hp' => $per_sec);
		$target->addEffects(new SR_Effect($seconds, $modifiers, SR_Effect::MODE_REPEAT));
		$this->announceADV($player, $target, $level);
		
		return true;
	}
	
//	public function cast_spell(Player $player, Player $target, $in_combat)
//	{
//		$tname = $target->get_name();
//		
//		$dmg = floor($this->level / 2);
//		
//		$duration = rand( 4, 6 + $this->level * 5 );
//		new Effect( $target, "hp", -$dmg, $this->rtime, $duration );
//		
//		$seconds = $duration * $this->rtime;
//		$msg = " cast Poison Dart on $tname. $tname will loose 1 HP all $this->rtime seconds for $seconds seconds.";
//		$player->get_party()->fight_message( $player->get_name(), $msg );
//	}
}

?>
