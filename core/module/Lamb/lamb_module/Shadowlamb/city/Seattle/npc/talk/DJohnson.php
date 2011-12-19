<?php
final class Seattle_DJohnson extends SR_TalkingNPC
{
	const TEMP_WORD = 'SEATTLE_JOHNSON_TALK';
	public function getName() { return 'Mr. Johnson'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
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
			case 'invite':
				$this->reply('Yes I know about the party.');
				break;
				
			case 'magic':
				$this->reply('If you have magic friends, you might want to introduce them to me.');
				$this->reply('Maybe you get a special bonus from me.');
				break;
				
			case 'renraku':
				$this->reply('Rarely the Renraku Inc. consults me to get dirty work done. It\'s not a secret. But mostly they have their own special forces to deal with problems.');
				break;
				
			case 'cyberware':
				$this->reply('You should check out the local computer store, in case you are looking for cyber stuff.');
				$this->reply('Here the laws are a bit more strict than in Redmond. You won\'t even get Reflex Boosters.');
				break;
				
			case 'redmond':
				$this->reply('I have lived in Redmond for a couple of years. A nice place for rednecks.');
				break;
				
			case 'seattle':
				$this->reply('We are in Seattle. The home of Renraku Inc. I doubt they would offer you a job, though.');
				break;

			case 'blackmarket':
				$this->reply('You need a permission to enter the blackmarket. Sadly all my permissions are sold out.');
				break;
			
			case 'yes':
				if ($t === true) {
					$q->accept($player);
					$this->reply('Ok, great. I hope you can get the job done.');
					$player->unsetTemp(self::TEMP_WORD);
				} else {
					$this->reply('Don`t try to get funny.');
				}
				break;
				
			case 'no':
				if ($t === true) {
					$this->reply('Come back when you are ready for a real run.');
					$player->unsetTemp(self::TEMP_WORD);
				} else {
					$this->reply('Yes I am. No` get outta my smoke scumbag.');
				}
				break;
				
			case 'shadowrun':
				if ($q === false) {
					$this->reply('Currently I have no job for you. Sorry chummer.');
				}
				elseif ($has === true) {
					$q->checkQuest($this, $player);
				}
				elseif ($t === true) {
					$this->reply('Do you accept your mission, fellow runner?');
				}
				elseif ($i === 0) {
					$this->reply('I already heard you are becoming a real runner, chumhead.');
					$this->reply('A contracter needs to get some TrollDeckers killed, and will pay 1000 Nuyen if you kill 15 of them. Do you accept the run?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				elseif ($i === 1) {
					$this->reply('I am sorry chummer, my contractor did a mistake. He does not need 15 Trolls killed, but their Renraku IDCards.');
					$this->reply('If you could at least collect 15 ID Cards, he would be very pleased.');
					$this->reply('I think it is still the right job for you isn\'t it?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				elseif ($i === 2) {
					$this->reply('You are a good boy, chummer. Your next mission is to punish Mogrid.');
					$this->reply('He ows a friend some favour, 50000 favors to be exact.');
					$this->reply("You better get some help from this friend. You will find him in the {$b}blackmarket{$b}. Just ask him about {$b}Shadowrun{$b}.");
					$player->giveKnowledge('words', 'Blackmarket');
					$this->reply('You can do that, right?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				break;
				
			default:
			case 'hello':
				if ($q === false) {
					$this->reply('Hello, I have no further jobs for you at the moment.');
				}
				elseif ($has === true) {
					$q->checkQuest($this, $player);
				}
				else {
					$this->reply('Take a seat, chummer. What do you have to tell?');
				}
				break;
		}
	}
}
?>