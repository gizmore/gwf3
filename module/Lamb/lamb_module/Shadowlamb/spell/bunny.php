<?php
final class Spell_bunny extends SR_SupportSpell
{
	public function getSpellLevel() { return 1; }
	
	public function getHelp() { return 'Make yourself #flee a combat.'; }
	public function getRequirements() { return array('magic'=>2); }
	public function getCastTime($level) { return Common::clamp(rand(10, 30)); }
	public function getManaCost(SR_Player $player)
	{
		$level = $this->getLevel($player);
		return Common::clamp(7-$level/4, 1);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits)
	{
		if ($target->getID() === $player->getID())
		{
			$player->message('You cannot cast bunny on other players.');
			return false;
		}

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
