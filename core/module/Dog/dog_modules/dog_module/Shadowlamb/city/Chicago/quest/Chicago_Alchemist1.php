<?php
final class Quest_Chicago_Alchemist1 extends SR_Quest
{
	public function getQuestName() { return 'Chemistry1'; }
	public function getNeededAmount() { return 2; }
	public function getQuestDescription() { return sprintf('Bring %d/%d Fairy Staffs to the Chicago Alchemist', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 6; }
	public function getRewardNuyen() { return 600; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'FairyStaff', $have_before, $need);
		
		if ($have > $have_before)
		{
			$npc->reply('Thank you a lot, chummer.');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$npc->reply('Ok chummer, i will now tell you howto #brew potions.');
			$npc->reply('Simply use the #brew <spell> [<level>] command and have a WaterBottle ready.');
			if ($player->getBase('alchemy') < 0)
			{
				$player->message('You have learned the alchemy skill and unlocked the #brew command.');
				$player->saveBase('alchemy', 0);
				$player->modify();
			}
			$this->onSolve($player);
			
			$npc->reply('You know what ... i give you 4 WaterBottles for a startup.');
			$player->giveItems(array(SR_Item::createByName('WaterBottle', 4)));
		}
		else
		{
			$npc->reply(sprintf('I still need %d Fairy Staffs for my experiments.', $need-$have));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Yes indeed, there is something we can do for each other ...");
				$npc->reply("I will show you how to perform alchemy, and you will bring me {$need} Fairy Staffs.");
				$npc->reply("Alright chummer?");
				break;
			case 'confirm':
				$npc->reply("Ok?");
				break;
			case 'yes':
				$npc->reply('It\'s a fair trade, isn\'t it?');
				break;
			case 'no':
				$npc->reply('Ok');
				break;
		}
		return true;
	}
}
?>