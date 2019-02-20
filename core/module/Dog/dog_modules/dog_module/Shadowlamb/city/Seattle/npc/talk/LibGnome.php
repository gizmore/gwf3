<?php
final class Seattle_LibGnome extends SR_TalkingNPC
{
	const TEMP_WORD = 'Seattle_LibGnome_TW';
	
	public function getName() { return 'Federico'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		$quests = array(
			SR_Quest::getQuest($player, 'Seattle_Library1'),
			SR_Quest::getQuest($player, 'Seattle_Library2'),
			SR_Quest::getQuest($player, 'Seattle_Library3'),
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
				$this->rply($word);
// 				$this->reply('I have no time for parties, I have to study the powers of magic.');
				$player->giveKnowledge('words', 'Magic');
				return true;
				
			case 'magic':
				return $this->rply($word);
// 				$this->reply('I am studying the powers of magic for a long time. If you help me out with some stuff I will teach you my most powerful spell.');
// 				break;
				
			case 'cyberware':
				return $this->rply($word);
// 				$this->reply('Cyberware will make you a bad magician. I would not recommend to use that kinda equipment. Please stop to interrupt my research now.');
// 				break;
				
			case 'redmond':
				return $this->rply($word);
// 				$this->reply('Redmond is a slum city. No magic people there. Not of interest to me.');
// 				break;
				
			case 'seattle':
			case 'blackmarket':
				return $this->rply('blackmarket');
// 				$this->reply('Could you please stop asking useless questions? Can\'t you see I am busy?');
// 				break;
			
			case 'yes':
				if ($t === true)
				{
					$this->rply('accept');
// 					$this->reply('Thank you. Now go and bring me the stuff.');
					$q->accept($player);
					$player->unsetTemp(self::TEMP_WORD);
				}
				else
				{
					$player->message($this->langNPC('no_react'));
// 					$player->message('The gnome doesn\'t react.');
				}
				return true;
				
			case 'no':
				if ($t === true)
				{
					$player->message($this->langNPC('working'));
// 					$player->message('The gnome continues his study work.');
					$player->unsetTemp(self::TEMP_WORD);
				}
				else
				{
					$player->message($this->langNPC('no_react'));
// 					$player->message('The gnome doesn\'t react.');
				}
				return true;
				
			case 'shadowrun':
				if ($q === false)
				{
					$this->rply('thx1');
// 					$this->reply('Thank you again for your help chummer.');
				}
				elseif ($has === true)
				{
					$q->checkQuest($this, $player);
				}
				elseif ($t === true)
				{
					$this->rply('more');
// 					$this->reply('Could you please bring me the items? I will teach you a cool magic spell as reward.');
				}
				elseif ($i === 0)
				{
					$this->rply('sr1', array($q->getNeededAmount()));
// 					$this->reply('Oh yes I have an important job for you. I have not eaten anything for days. Could you please bring me '.$q->getNeededAmount().' Pringles?');
					$this->rply('sr2');
// 					$this->reply('I will teach you a great magic spell then. What do you think?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				elseif ($i === 1)
				{
					$this->rply('sr3', array($q->getNeededAmount()));
// 					$this->reply('Magic spell? I could teach you one if you bring me '.$q->getNeededAmount().' bacon. What do you think?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				elseif ($i === 2)
				{
					$this->rply('sr4', array($q->getNeededAmount()));
// 					$this->reply('Magic spell? I never said that. But I will teach you one if you bring me '.$q->getNeededAmount().' ElvenStaffs. Accept?');
					$player->setTemp(self::TEMP_WORD, true);
				}
				return true;
				
			case 'auris':
				return $this->onTalkAuris($player);
				
			default:
			case 'hello':
				if ($q === false)
				{
					$this->rply('thx1');
// 					$this->reply('Thank you again for your help chummer.');
				}
				elseif ($has === true)
				{
					$q->checkQuest($this, $player);
				}
				else
				{
					$this->rply('default', array($this->getName()));
// 					$this->reply(sprintf('Hello chummer. My name is %s. As you can see I am busy. Also be quiet here!', $this->getName()));
				}
				return true;
		}
	}
	
	private function onTalkAuris(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Delaware_Exams5');
		$quest instanceof Quest_Delaware_Exams5;
// 		if (!$quest->isInQuest($player))
// 		{
// 			return $this->reply('You came for a pot of fluid Auris? ... I am too busy now. Come back tomorrow.');
// 		}
		
		$auris = $player->getInvItemByName('Auris');
		
		if ($auris === false)
		{
			$auris = SR_Item::createByName('Auris');
			$player->message($this->langNPC('auris1'));
// 			$player->message('The gnome casts a magic spell and presents you a pot of fluid Auris');
			$this->rply('auris2');
// 			$this->reply("Here chummer, this is a pot of fluid Auris. Use it quick as it will turn to stone after a few minutes");
			$player->giveItems(array($auris), 'library gnome');
			$quest->resetTimer($player);
			return true;
		}
		else
		{
			$player->message($this->langNPC('auris3'));
// 			$player->message('The gnome casts a magic spell and your pot of Auris is fluid again.');
			$quest->resetTimer($player);
			$this->rply('auris4');
// 			$this->reply("Here chummer, Your Auris is fluid again. Use it quick as it will turn to stone after a few minutes");
			return true;
		}
	}
}
?>