<?php
final class Quest_Redmond_Johnson_3 extends SR_Quest
{
	public function getQuestDescription() { return 'Deliver a package to the Hotelier in Seattle_Hotel.'; }
	
	public function accept(SR_Player $player)
	{
		parent::accept($player);
		$player->giveItems(SR_Item::createByName('Package'));
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($npc instanceof Seattle_Hotelier)
		{
			$this->checkQuestHotelier($npc, $player);
		}
		else
		{
			$this->checkQuestJohnson($npc, $player);
		}
	}
	
	private function checkQuestHotelier(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getQuestData();
		if (isset($data['gave'])) {
			return;
		}
		
		if (false === ($item = $player->getInvItemByName('Package'))) {
			return;
		}
		
		if (false === $player->removeFromInventory($item)) {
			return;
		}
		
		$data['gave'] = 1;
		$this->saveQuestData($data);
		$player->message('You give the package to the hotelier: "Here is a package for you from Mr.Johnson".');
		$npc->reply('Oh, Thank you. I am sure Mr.Johnson will reward you well.');
	}

	private function checkQuestJohnson(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getQuestData();
		if (!isset($data['gave'])) {
			return;
		}
		$nuyen = 750;
		$npc->reply('I have heard you delivered the package. Thank you chummer.');
		$player->message('Mr. Johnson hands you '.$nuyen.' Nuyen.');
		$this->onSolve($player);
	}
}
?>