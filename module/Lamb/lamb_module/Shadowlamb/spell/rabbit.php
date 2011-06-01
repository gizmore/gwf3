<?php
final class Spell_rabbit extends SR_SupportSpell
{
	public function getSpellLevel() { return 1; }
	
	public function getHelp() { return 'Make a party member #flee a combat.'; }
	public function getRequirements() { return array('magic'=>2); }
	public function getCastTime($level) { return Common::clamp(rand(20, 40)); }
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return Common::clamp(10-$level/2, 2);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$this->announceADV($player, $target, $level);
		
		if ($hits > $this->getManaCost())
		{
			Shadowcmd_flee::onFlee($player);
			return true;
		}
		return true;
	}
}
?>
