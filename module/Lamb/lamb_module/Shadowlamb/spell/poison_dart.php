<?php
final class Spell_poison_dart extends SR_Spell
{
	public function isOffensive() { return true; }

	public function getHelp(SR_Player $player) { return 'Poisons an enemy.'; }
	
	public function getRequirements() { return array('magic'=>3); }
	
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return $level + 6;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
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
