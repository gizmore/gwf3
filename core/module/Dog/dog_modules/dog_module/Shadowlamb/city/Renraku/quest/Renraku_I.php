<?php
final class Quest_Renraku_I extends SR_Quest
{
// 	public function getQuestName() { return 'Renraku1'; }
// 	public function getQuestDescription() { return 'Gather information about Renraku and your role in the conspiracy. You need to reach level 8 and travel to Seattle to accomplish this quest.'; }
	
	public function checkOrk(SR_Player $player)
	{
		$data = $this->getQuestData();
		return isset($data['ORK1']);
	}
	
	public function setOrk(SR_Player $player)
	{
		$data = $this->getQuestData();
		$data['ORK1'] = 1;
		$this->saveQuestData($data);
		
		$player->message($this->lang('orkmsg'));
// 		$player->message('The Ork dies. You grab his knife. It has "Renraku" as initials.');
		$player->giveItems(array(SR_Item::createByName('Knife')), 'The Ork');
	}
}
?>