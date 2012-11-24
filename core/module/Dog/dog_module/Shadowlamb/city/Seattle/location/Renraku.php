<?php
final class Seattle_Renraku extends SR_Entrance
{
	public function getFoundPercentage() { return 40.00; }
// 	public function getFoundText(SR_Player $player) { return 'You found the Renraku Inc. Headquarters. They have an office in every metropole meanwhile. You see a few guards at the entrance.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
// 	public function getEnterText(SR_Player $player) {}

	public function getExitLocation() { return 'Renraku_Exit'; }
	
	public function onEnter(SR_Player $player)
	{
		$p = $player->getParty();
		
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			if (!$member->getInvItemByName('IDCardA'))
			{
				SR_NPC::createEnemyParty('Renraku_Guard','Renraku_Guard','Renraku_Guard')->talk($p, true);
				return true;
			}
		}
		
		return parent::onEnter($player);
	}
}
?>
