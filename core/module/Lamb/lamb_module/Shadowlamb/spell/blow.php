<?php
final class Spell_blow extends SR_CombatSpell
{
	public function getSpellLevel() { return 1; }
	public function getHelp() { return 'Blow an enemy away to increase his distance.'; }
	public function getCastTime($level) { return 45; }
	public function getRequirements() { return array('magic'=>2); }
	public function getRange() { return 4.0; }
	public function getManaCost(SR_Player $player, $level)
	{
		return 4 + $level;
//		return 4 + $this->getLevel($player);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$lev = $this->getLevel($player);
		$int = $player->get('intelligence');
		$wis = $player->get('wisdom');
		
		$min = 0.5;
		$min += $level * 0.2;
		$min += $wis * 0.2;
		$min += $int * 0.1;
		$min += $hits * 0.1;
		
		$max = $min * 2;
		
		$metres = Shadowfunc::diceFloat($min, $max, 2);
		
		$ep = $target->getParty();
		$ep->movePlayer($target, false, $metres);
		
		$append = sprintf('%s got blown away %s metres and is now on position %s.', $target->getName(), $metres, $target->getY());
		
		$this->announceADV($player, $target, $level, $append);
		
		return true;
	}	
}
?>