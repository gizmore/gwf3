<?php
final class Spell_rabbit extends SR_SupportSpell
{
	public function getSpellLevel() { return 3; }
	
	public function getHelp() { return 'Make your whole party flee from combat.'; }
	public function getRequirements() { return array('magic'=>2); }
	public function getCastTime($level) { return Common::clamp(rand(20, 40)); }
	public function getManaCost(SR_Player $player, $level)
	{
		return Common::clamp(10-$level/2, 2);
	}
	
	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player)
	{
		$this->announceADV($player, $target, $level);
		
		if ($hits > $this->getManaCost($player, $level))
		{
			foreach ($player->getParty()->getMembers() as $member)
			{
				Shadowcmd_flee::onFlee($member);
			}
		}
		return true;
	}
}
?>
