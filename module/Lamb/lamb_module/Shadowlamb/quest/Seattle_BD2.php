<?php
final class Quest_Seattle_BD2 extends SR_Quest
{
	const REWARD_RUNES = 3;
	
	public function getQuestName() { return 'PoorSmith2'; }
	public function getNeededAmount() { return 20; }
	public function getQuestDescription() { return sprintf('Bring %s/%s Runes to the Seattle Blacksmith.', $this->getAmount(), $this->getNeededAmount()); }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getAmount();
		$need = $this->getNeededAmount();
		$give = 0;
		
		foreach ($player->getInventory() as $item)
		{
			if ($item instanceof SR_Rune)
			{
				$player->removeFromInventory($item);
				$have++;
				$give++;
				if ($have >= $need) {
					break;
				}
			}
		}
		
		if ($give > 0)
		{
			$this->increase('sr4qu_amount', $give);
			$player->message(sprintf('You gave %s %s to %s.', $give, 'Runes', $npc->getName()));
		}
		
		
		if ($have >= $need)
		{
			$npc->reply('Thank you very much my friend. Now i can also craft some equipment again.');
			$this->onSolve($player);
			$npc->reply('As a reward i let you create '.self::REWARD_RUNES.' new runes via #reward.');
			$player->increaseConst(Seattle_Blacksmith::REWARD_RUNES, self::REWARD_RUNES);
		}
		else
		{
			$npc->reply(sprintf('You gave me %s of %s Runes... give me a few more and i will reward you greatly :)', $have, $need));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word)
	{
		switch ($word)
		{
			case 'confirm':
				$npc->reply('Could you please help me again?');
				break;
			case 'shadowrun':
				$npc->reply('Now i have some clean swords, nice for keeping up the business.');
				$npc->reply('Next i could really need a few Runes.');
				$npc->reply('Could you please bring me '.$this->getNeededAmount().' runes? I can reward you with some special runes for your help :)');
				break;
			case 'yes':
				$npc->reply(sprintf('Please bring me %s Runes. WARNING: I will take any rune from your inventory!', $this->getNeededAmount()));
				break;
			case 'no':
				$npc->reply('Feel free to trade then.');
				break;
		}
	}
}
?>
