<?php
final class Redmond_Barkeeper extends SR_TalkingNPC
{
	const TEMP_WORD = 'Redmond_Barkeeper_sr';
	
	public function getName() { return 'The barkeeper'; }
	
	public function onNPCTalk(SR_Player $player, $word)
	{
		$b = chr(2);
		$quest = SR_Quest::getQuest($player, 'Redmond_Barkeeper');
		$done = $quest->isDone($player);
		$has = $quest->isInQuest($player);
		$t = $player->hasTemp(self::TEMP_WORD);
		$ns = Quest_Redmond_Barkeeper::NEED_SMALL_BEER;
		$nl = Quest_Redmond_Barkeeper::NEED_LARGE_BEER;
		$nb = Quest_Redmond_Barkeeper::NEED_BOOZE;
		
		switch ($word)
		{
			case 'yes':
				if ($t === false)
				{
					$this->reply('Yes, what?');
				}
				else
				{
					$this->reply('Thanks, chummer. I am waiting for your delivery.');
					$quest->accept($player);
					$player->unsetTemp(self::TEMP_WORD);
				}
				break;
				
			case 'no':
				if ($t === false)
				{
					$this->reply('No...what?');
				}
				else
				{
					$this->reply('Ok, then not. I would pay you well');
					$player->unsetTemp(self::TEMP_WORD);
				}
				break;
				
			case 'shadowrun':
				if ($has === true)
				{
					$quest->checkQuest($this, $player);
				}
				elseif ($done === true)
				{
					$this->reply('I don`t have another job, but you could ask Mr.Johnson over there.');
				}
				elseif ($t === true)
				{
					$this->reply('What do you say, chummer? Could you accomplish this quest for me?');
				}
				else
				{
					$this->reply('So you are a runner? Very doubtful...');
					$this->reply('Well... actually you could do me a favor.');
					$this->reply('There is a party next weekend, and it seems to be impossible to get any booze.');
					$this->reply("There is no {$b}blackmarket{$b} here in Redmond, so i have no idea how to get some beer and stuff...");
					$this->reply(sprintf('Could you please bring me %d SmallBeer, %d LargeBeer and %d Booze?', $ns, $nl, $nb));
					$player->giveKnowledge('words', 'Blackmarket', 'Yes', 'No');
					$player->setTemp(self::TEMP_WORD, true);
				}
				break;
			default:
			case 'hello':
				if ($has)
				{
					$quest->checkQuest($this, $player);
				}
				else
				{
					$this->reply('Hello my friend. How may i serve you?');
				}
				break;
		}
		
	}
}
?>