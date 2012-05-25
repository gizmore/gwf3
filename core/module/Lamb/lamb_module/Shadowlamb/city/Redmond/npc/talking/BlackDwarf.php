<?php
final class Redmond_BlackDwarf extends SR_TalkingNPC
{
	const TEMP_WORD = 'Redmond_BlackDwarf_sr';
	public function getName() { return 'Galdor'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		$quest = SR_Quest::getQuest($player, 'Redmond_Blacksmith');
		$has = $quest->isInQuest($player);
		$done = $quest->isDone($player);
		
		switch ($word)
		{
			case 'yes':
				if ($player->hasTemp(self::TEMP_WORD))
				{
					$this->rply('yes2');
// 					$this->reply('Thank you chummer, I really need it and can`t leave.');
					$player->unsetTemp(self::TEMP_WORD);
					$quest->accept($player);
				}
				else
				{
					$this->rply('yes1');
// 					$this->reply('Yes chummer!');
				}
				break;
				
			case 'no':
				if ($player->hasTemp(self::TEMP_WORD))
				{
					$this->rply('no2');
// 					$this->reply('Ok, if you don`t have time I have to look for another chummer');
					$player->unsetTemp(self::TEMP_WORD);
				}
				else
				{
					$this->rply('no1');
// 					$this->reply('No what?');
				}
				break;
				
			case 'runecrafting': case 'rune': case 'runes':
			case 'smithing': case 'smith':
				if ($has)
				{
					$quest->checkQuest($this, $player);
				}
				elseif ($player->hasTemp(self::TEMP_WORD))
				{
					$this->rply('pls');
// 					$this->reply('Can you?');
				}
				elseif ($done)
				{
					$this->rply('thx');
// 					$this->reply('Thanks to you, I can smith and runecraft items again :)');
				}
				elseif ($has)
				{
					$this->rply('aww');
// 					$this->reply('I still have no SmithHammer. No hammer, No business. :/');
				}
				else
				{
					$this->rply('run1');
					$this->rply('run2');
// 					$this->reply('Yeah, I am the best smith in town, but somebody stole my SmithHammer. The bad thing is I can`t leave to buy one, as I wait for a special delivery of runes.');
// 					$this->reply('Can you bring me one, so I can continue with my business?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				break;
				
			case 'hello':
				if ($has)
				{
					$quest->checkQuest($this, $player);
				}
				else
				{
					$player->giveKnowledge('words', 'Smithing');
					$this->rply('hello');
// 					$this->reply("Hello. I am Galdor and I master the art of {$b}smithing{$b} and {$b}runecrafting{$b}.");
				}
				break;
				
			default:
				$this->rply('default', array($word));
// 				$this->reply("I don`t know anything about $word.");
				break;
		}
		return true;
	}
}
?>
