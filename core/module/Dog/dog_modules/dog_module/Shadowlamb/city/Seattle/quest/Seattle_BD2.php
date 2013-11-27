<?php
final class Quest_Seattle_BD2 extends SR_Quest
{
	const REWARD_RUNES = 3;
	
	public function getNeededAmount() { return 20; }
	
// 	public function getQuestName() { return 'PoorSmith2'; }
// 	public function getQuestDescription() { return sprintf('Bring %s/%s Runes to the Seattle Blacksmith.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getAmount();
		$need = $this->getNeededAmount();
		$give = 0;
		
		foreach ($player->getInventory() as $item)
		{
			if ($item instanceof SR_Rune)
			{
				$player->deleteFromInventory($item);
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
			$player->message($this->lang('gave', array($give, $npc->getName())));
// 			$player->message(sprintf('You gave %s %s to %s.', $give, 'Runes', $npc->getName()));
		}
		
		
		if ($have >= $need)
		{
			$npc->reply($this->lang('thanks1'));
// 			$npc->reply('Thank you very much my friend. Now I can also craft some equipment again.');
			$this->onSolve($player);
			$npc->reply($this->lang('thanks2', array(self::REWARD_RUNES)));
// 			$npc->reply('As a reward I let you create '.self::REWARD_RUNES.' new runes via #reward.');
			$player->increaseConst(Seattle_Blacksmith::REWARD_RUNES, self::REWARD_RUNES);
		}
		else
		{
			$npc->reply($this->lang('more', array($have, $need)));
// 			$npc->reply(sprintf('You gave me %s of %s Runes... Give me a few more and I will reward you greatly :)', $have, $need));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'confirm':
				$npc->reply($this->lang('confirm'));
// 				$npc->reply('Could you please help me again?');
				break;
			case 'shadowrun':
				$npc->reply($this->lang('shadowrun1'));
				$npc->reply($this->lang('shadowrun2'));
				$npc->reply($this->lang('shadowrun3', array($this->getNeededAmount())));
// 				$npc->reply('Now I have some clean swords, nice for keeping up the business.');
// 				$npc->reply('Next I could really need a few Runes.');
// 				$npc->reply('Could you please bring me '.$this->getNeededAmount().' runes? I can reward you with some special runes for your help :)');
				break;
			case 'yes':
				$npc->reply($this->lang('yes', array($this->getNeededAmount())));
// 				$npc->reply(sprintf('Please bring me %s Runes. WARNING: I will take any rune from your inventory!', $this->getNeededAmount()));
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Feel free to trade then.');
				break;
		}
		return true;
	}
}
?>
