<?php
/**
 * The flu spell will reduce an enemies hp slowly.
 * @author gizmore
 */
final class Spell_flu extends SR_OffensiveSpell
{
	public function getSpellLevel() { return 1; }
	public function getHelp() { return sprintf('Poisons an enemy which reduces it\'s HP slowly.'); }
	public function getRequirements() { return array('magic'=>2); }
	public function getCastTime($level) { return Common::clamp(30-$level, 20, 40); }
	public function getManaCost(SR_Player $player, $level)
	{
//		$level = $this->getLevel($player);
		return $level + 2;
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
		$seconds = Common::clamp(90-$hits, 30, 90);
		$amount = rand($level, $level+$hits/3) + rand(0, $player->get('wisdom'));
		$per_sec = round($amount / $seconds, 2);
		$per_sec = $this->lowerSpellIncrement($target, $per_sec, 'hp');
		echo "Casting flu with level $level and $hits hits. The target will loose $amount HP within $seconds seconds.\n";
		$modifiers = array('hp' => -$per_sec);
		$target->addEffects(new SR_Effect($seconds, $modifiers, SR_Effect::MODE_REPEAT));
		
		$this->announceADV($player, $target, $level);
		return true;
	}
}