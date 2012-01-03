<?php
final class Redmond_Johnson extends SR_TalkingNPC
{
	const TEMP_WORD = 'Redmond_Johnson_sr';
	
	public function getName() { return 'Mr. Johnson'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (true === SR_Quest::getQuest($player, 'Chicago_OwlJohnsonRoundtrip')->onRoundtripShow($player, $this))
		{
			return true;
		}
		
		$quests = array(
			SR_Quest::getQuest($player, 'Redmond_Johnson_1'),
			SR_Quest::getQuest($player, 'Redmond_Johnson_2'),
			SR_Quest::getQuest($player, 'Redmond_Johnson_3'),
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
			case 'seattle':
				$this->reply('If you think Redmond is a dangerous place I would not go there.');
				break;

			case 'blackmarket':
				$this->reply('Listen, there is no blackmarket in Redmond. And I never heard of a blackmarket anyway.');
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
					$this->reply('Hello, I have no further quests for you at the moment... You should maybe go to Seattle...');
				}
				elseif ($has === true) {
					$q->checkQuest($this, $player);
				}
				elseif ($t === true) {
					$this->reply('Do you accept your mission, fellow runner?');
				}
				elseif ($i === 0) {
					$this->reply('Shhh... You wanna become a real runner?');
					$this->reply('You should first proof that you are worth of getting important jobs from me.');
					$this->reply('As a starter you could kill 10 Lamers for me, agreed?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				elseif ($i === 1) {
					$this->reply('Ok my friend, I need some equipment for another job regarding the punks.');
					$this->reply('A fellow runner will be contracted to infiltrate their Hideout, but I need some of their usual equipment.');
					$this->reply('Please bring me a BikerJacket and a BikerHelmet as soon as possible.');
					$this->reply('Can you do that for me?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				elseif ($i === 2) {
					$this->reply('Now this mission is really important: please deliver a package to the Hotelier in Seattle.');
					$this->reply('Do you accept the mission?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				break;
				
			default:
			case 'hello':
				if ($q === false) {
					$this->reply('Hello, I have no further quests for you at the moment... You should maybe got to Seattle...');
				}
				elseif ($has === true) {
					$q->checkQuest($this, $player);
				}
				else {
					$this->reply('What`s up chummer? Can`t you see I am busy?');
				}
				break;
		}
	}
}
?>
