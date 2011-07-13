<?php
final class Quest_Delaware_Seraphim2 extends SR_Quest
{
	public function getQuestName() { return 'FirstEmployee'; }
	public function getQuestDescription() { return sprintf('Find a troll that will work for the SecondHandDwarf in Delaware.'); }
	public function getRewardXP() { return 5; }
	public function getRewardNuyen() { return 250; }
	public function getRewardItems() { return array('Scanner_v4'); }

	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getQuestData();
		if (isset($data['WORKER']))
		{
			$name = $data['WORKER'];
			$npc->reply(sprintf('Thank you so very very much. %s is doing a good job :)'));
			$npc->reply(sprintf('He found a used Scanner_v4 too. I guess you can have it!'));
			$this->onSolve($player);
		}
		else
		{
			$npc->reply(sprintf('Sad to hear you could not find anybody yet.'));
		}
	}
	
	public function isWorkerFound()
	{
		$data = $this->getQuestData();
		return isset($data['WORKER']);
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
				$npc->reply("Hehe chummer ... i think i can not take care of the shop all alone.");
				$npc->reply("If you could maybe find a troll that would work for me?");
				$npc->reply("Just ask him about \X02shadowrun\X02.");
				break;
			case 'confirm':
				$npc->reply("Just ask him about \X02shadowrun\X02.");
				break;
			case 'yes':
				$npc->reply('Ok.');
				break;
			case 'no':
				$npc->reply('Please.');
				break;
		}
		return true;
	}
}
?>