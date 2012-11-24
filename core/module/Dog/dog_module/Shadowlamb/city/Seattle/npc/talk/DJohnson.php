<?php
final class Seattle_DJohnson extends SR_TalkingNPC
{
	const TEMP_WORD = 'SEATTLE_JOHNSON_TALK';
	public function getName() { return 'Mr. Johnson'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (true === SR_Quest::getQuest($player, 'Chicago_OwlJohnsonRoundtrip')->onRoundtripShow($player, $this))
		{
			return true;
		}
		
		$b = chr(2);
		$quests = array(
			SR_Quest::getQuest($player, 'Seattle_Johnson1'),
			SR_Quest::getQuest($player, 'Seattle_Johnson2'),
			SR_Quest::getQuest($player, 'Seattle_Johnson3'),
		);
		$q = false;
		$i = -1;
		foreach ($quests as $id => $quest)
		{
			$quest instanceof SR_Quest;
			if(!$quest->isDone($player)) {
				$q = $quest;
				$i = $id;
				break;
			}
		}
		$has = $q === false ? false : $q->isInQuest($player);
		$t = $player->hasTemp(self::TEMP_WORD);
		
		switch ($word)
		{
			case 'malois':
				$this->rply('malois');
// 				$this->reply("Listen chummer, if i were you, i would stop to worry about guys like him. You don't want to end as {$b}bribe{$b}, do you?");
				$player->giveKnowledge('words', 'Bribe');
				break;
			
			case 'invite':
				$this->rply('invite');
// 				$this->reply('Yes I know about the party.');
				break;
				
			case 'magic':
				$this->rply('magic1');
// 				$this->reply('If you have magic friends, you might want to introduce them to me.');
				$this->rply('magic2');
// 				$this->reply('Maybe you get a special bonus from me.');
				break;
				
			case 'renraku':
				$this->rply('renraku');
// 				$this->reply('Rarely the Renraku Inc. Consults me to get dirty work done. It\'s not a secret. But mostly they have their own special forces to deal with problems.');
				break;
				
			case 'cyberware':
				$this->rply('cyber1');
// 				$this->reply('You should check out the local computer store, in case you are looking for cyber stuff.');
				$this->rply('cyber2');
// 				$this->reply('Here the laws are a bit more strict than in Redmond. You won\'t even get Reflex Boosters.');
				break;
				
			case 'redmond':
				$this->rply('redmond');
// 				$this->reply('I have lived in Redmond for a couple of years. A nice place for rednecks.');
				break;
				
			case 'seattle':
				$this->rply('seattle');
// 				$this->reply('We are in Seattle. The home of Renraku Inc. I doubt they would offer you a job, though.');
				break;

			case 'blackmarket':
				$this->rply('blackmarket');
// 				$this->reply('You need a permission to enter the blackmarket. Sadly all my permissions are sold out.');
				break;
			
			case 'yes':
				if ($t === true)
				{
					$q->accept($player);
					$this->rply('yes1');
// 					$this->reply('Ok, great. I hope you can get the job done.');
					$player->unsetTemp(self::TEMP_WORD);
				}
				else
				{
					$this->rply('yes2');
// 					$this->reply('Don`t try to get funny.');
				}
				break;
				
			case 'no':
				if ($t === true)
				{
					$this->rply('no1');
// 					$this->reply('Come back when you are ready for a real run.');
					$player->unsetTemp(self::TEMP_WORD);
				}
				else
				{
					$this->rply('no2');
// 					$this->reply('Yes I am. No` get outta my smoke scumbag.');
				}
				break;
				
			case 'shadowrun':
				if ($q === false)
				{
					$this->rply('sr1');
// 					$this->reply('Currently I have no job for you. Sorry chummer.');
				}
				elseif ($has === true)
				{
					$q->checkQuest($this, $player);
				}
				elseif ($t === true)
				{
					$this->rply('sr2');
// 					$this->reply('Do you accept your mission, fellow runner?');
				}
				elseif ($i === 0)
				{
					$this->rply('sr3');
// 					$this->reply('I already heard you are becoming a real runner, chumhead.');
					$this->rply('sr4');
// 					$this->reply('A contracter needs to get some TrollDeckers killed, and will pay 1000 Nuyen if you kill 15 of them. Do you accept the run?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				elseif ($i === 1)
				{
					$this->rply('sr5');
// 					$this->reply('I am sorry chummer, my contractor did a mistake. He does not need 15 Trolls killed, but their Renraku IDCards.');
					$this->rply('sr6');
// 					$this->reply('If you could at least collect 15 ID Cards, he would be very pleased.');
					$this->rply('sr7');
// 					$this->reply('I think it is still the right job for you isn\'t it?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				elseif ($i === 2)
				{
					$this->rply('sr8');
// 					$this->reply('You are a good boy, chummer. Your next mission is to punish Mogrid.');
					$this->rply('sr9');
// 					$this->reply('He ows a friend some favors, 50000 favors to be exact.');
					$this->rply('sr10');
// 					$this->reply("You better get some help from this friend. You will find him in the {$b}blackmarket{$b}. Just ask him about {$b}Shadowrun{$b}.");
					$player->giveKnowledge('words', 'Blackmarket');
					$this->rply('sr11');
// 					$this->reply('You can do that, right?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				break;
				
			default:
			case 'hello':
				if ($q === false)
				{
					$this->rply('hello1');
// 					$this->reply('Hello, I have no further jobs for you at the moment.');
				}
				elseif ($has === true)
				{
					$q->checkQuest($this, $player);
				}
				else
				{
					$this->rply('hello2');
// 					$this->reply('Take a seat, chummer. What do you have to tell?');
				}
				break;
		}
		
		return true;
	}
}
?>
