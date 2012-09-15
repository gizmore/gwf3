<?php
final class Seattle_DBarkeeper extends SR_TalkingNPC
{
	const TEMP_WORD = 'Seattle_Barkeeper_Run';
	
// 	public function getName() { return 'The barkeeper'; }
	public function getName() { return $this->langNPC('name'); }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_Barkeeper');
		$need = $quest->getNeededAmount();
		if ($quest->isInQuest($player))
		{
			$quest->checkQuest($this, $player);
			if ($quest->isDone($player))
			{
				return;
			}
		}
		
		switch ($word)
		{
			case 'shadowrun':
				
				if ($quest->isDone($player))
				{
					return $this->rply('thx');
// 					$msg = 'Thank you again for your help. The party will surely be great!';
				}
				elseif ($quest->isInQuest($player))
				{
					return true;
// 					return $this->rply('more');
// 					$msg = 'Please invite more citizens to our party!';
				}
				elseif (!$player->hasTemp(self::TEMP_WORD))
				{
					$this->rply('sr1');
// 					$this->reply('Haha, a runner... Everybody keeps asking me for jobs. Well... I have a job for you!');
					$this->rply('sr2', array($need));
// 					$this->reply("We have a big party here next weekend, but we need way more guests. Could you please invite {$need} random citizens to the party?");
					$player->giveKnowledge('words', 'invite');
					$player->setTemp(self::TEMP_WORD, 1);
					return true;
				}
				else
				{
					return $this->rply('sr3');
// 					$msg = 'What do you say, chummer?';
				}
				break;
				
			case 'blackmarket': #$msg = 'I don\'t talk about illegal stuff. Order a drink and enjoy the evening please.'; break;
			case 'renraku': #$msg = 'One of our guests keeps telling weird stories about Renraku, but I doubt the facts. Maybe you like to talk to the elve over there.'; break;
			case 'magic': #$msg = 'My drinks are magic :) You should try the "Disconnector". It is really explosive'; break;
			case 'malois': #$msg = 'Yeah, i think i have seen that elve lately. Why?'; break; 
				return $this->rply($word);
				
			case 'yes': 
				if ($player->hasTemp(self::TEMP_WORD))
				{
					$this->rply('accept');
					$quest->accept($player);
// 					$msg = 'Just use "#say invite" when you meet citizens on the street. Thank you in advance!';
					$player->unsetTemp(self::TEMP_WORD);
					return true;
				}
				else
				{
					return $this->rply('yes');
// 					$msg = 'Yeah, totally!';
				}
// 				break;
				
				
			case 'no':
				$player->unsetTemp(self::TEMP_WORD);
				return $this->rply('no');
// 				$msg = 'Oh, ok.';
// 				break;
				
			default: 
				return $this->rply('default');
				#$msg = 'Good evening. Welcome to the Deckers.'; break;
		}
// 		return $this->reply($msg);
	}
}
?>
