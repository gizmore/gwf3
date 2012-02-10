<?php
final class Spell_bunny extends SR_SupportSpell
{
	public function getSpellLevel() { return 1; }
	
	public function getHelp() { return 'Make a party member #flee from combat.'; }
	public function getRequirements() { return array('magic'=>2); }
	public function getCastTime($level) { return Common::clamp(rand(10, 30)); }
	public function getManaCost(SR_Player $player, $level)
	{
		return Common::clamp(7-$level/4, 1);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
		$this->announceADV($player, $target, $level);
		if ($hits > $this->getManaCost($player, $level))
		{
			Shadowcmd_flee::onFlee($target);
		}
		return true;
	}
}
?>
