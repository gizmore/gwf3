<?php
final class Cave_BigCave extends SR_Location
{
	public function getFoundPercentage() { return 25; }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
		$player->getParty()->fight(SR_NPC::createEnemyParty('Forest_ZombieBear'));
		return true;
	}
}
?>
