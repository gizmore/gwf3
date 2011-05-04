<?php
final class Quest_Renraku_I extends SR_Quest
{
	public function getQuestDescription() { return 'Gather information about Renraku and your role in the conspiracy.'; }
	
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
		
		$player->message('The ork dies. You grab his knife. It has "Renraku" as initials.');
		$player->giveItems(SR_Item::createByName('Knife'));
	}
	
}
?>