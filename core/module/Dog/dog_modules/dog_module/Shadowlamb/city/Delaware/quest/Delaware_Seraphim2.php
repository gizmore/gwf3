<?php
final class Quest_Delaware_Seraphim2 extends SR_Quest
{
// 	public function getQuestName() { return 'FirstEmployee'; }
// 	public function getQuestDescription() { return sprintf('Find a troll that will work for the SecondHandDwarf in Delaware.'); }
	public function getRewardXP() { return 5; }
	public function getRewardNuyen() { return 250; }
	public function getRewardItems() { return array('Scanner_v4'); }

	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getQuestData();
		if (isset($data['WORKER']))
		{
			$name = $data['WORKER'];
			$npc->reply($this->lang('thx1', array($name)));
// 			$npc->reply(sprintf('Thank you so very very much. %s is doing a good job :)', $name));
			$npc->reply($this->lang('thx2'));
// 			$npc->reply(sprintf('He found a used Scanner_v4 too. I guess you can have it!'));
			$this->onSolve($player);
		}
		else
		{
			$npc->reply($this->lang('more'));
// 			$npc->reply(sprintf('Sad to hear you could not find anybody yet.'));
		}
		return true;
	}
	
	public function isWorkerFound()
	{
		$data = $this->getQuestData();
		return isset($data['WORKER']);
	}
        
	public function getWorkerName()
	{
		$data = $this->getQuestData();
		if (isset($data['WORKER']))
		{
			return $data['WORKER'];
		}
		return null;
	}

	public function setWorkerFound($name)
	{
		$data = $this->getQuestData();
		$data['WORKER'] = $name;
		return $this->saveQuestData($data);
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
// 				$npc->reply("Hehe chummer ... I think I can not take care of the shop all alone.");
				$npc->reply($this->lang('sr2'));
// 				$npc->reply("If you could maybe find a troll that would work for me?");
				$npc->reply($this->lang('sr3'));
// 				$npc->reply("Just ask him about \X02shadowrun\X02.");
				break;
			case 'confirm':
				$npc->reply($this->lang('sr3'));
// 				$npc->reply("Just ask him about \X02shadowrun\X02.");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('Ok.');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Please.');
				break;
		}
		return true;
	}
}
?>
