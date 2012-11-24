<?php
final class Quest_Redmond_Johnson_3 extends SR_Quest
{
// 	public function getQuestName() { return 'Delivery'; }
// 	public function getQuestDescription() { return 'Deliver a package to the Hotelier in Seattle_Hotel.'; }
	
	public function getRewardXP() { return 6; }
	public function getRewardNuyen() { return 750; }
	
	public function accept(SR_Player $player)
	{
		$player->giveItems(array(SR_Item::createByName('Package')));
		return parent::accept($player);
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($npc instanceof Seattle_Hotelier)
		{
			return $this->checkQuestHotelier($npc, $player);
		}
		else
		{
			return $this->checkQuestJohnson($npc, $player);
		}
	}
	
	private function checkQuestHotelier(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getQuestData();
		if (isset($data['gave'])) {
			return false;
		}
		
		if (false === ($item = $player->getInvItemByName('Package'))) {
			return false;
		}
		
		if (false === $player->deleteFromInventory($item)) {
			return false;
		}
		
		$data['gave'] = 1;
		$this->saveQuestData($data);
		$player->message($this->lang('give1'));
		$npc->reply($this->lang('give2'));
		$player->message($this->lang('give3'));
// 		$player->message('You give the package to the hotelier: "Here is a package for you from Mr.Johnson!"');
// 		$npc->reply('Oh, Thank you. I am sure Mr.Johnson will reward you well.');
// 		$player->message('The hotelier takes the package');
		return true;
	}

	private function checkQuestJohnson(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getQuestData();
		if (!isset($data['gave']))
		{
			$npc->reply($this->lang('notyet'));
// 			$npc->reply('It seems like you did not deliver the package yet.');
			return false;
		}
// 		$xp = 6;
// 		$ny = 750;
		$npc->reply($this->lang('reward1'));
		$player->message($this->lang('reward2', array($this->getRewardNuyen(), $this->getRewardXP())));
// 		$npc->reply('I have heard you delivered the package. Thank you chummer.');
// 		$player->message('Mr. Johnson hands you '.$ny.' Nuyen. You also gained '.$xp.' XP.');
// 		$player->giveXP($xp);
// 		$player->giveNuyen($ny);
		return $this->onSolve($player);
	}
}
?>