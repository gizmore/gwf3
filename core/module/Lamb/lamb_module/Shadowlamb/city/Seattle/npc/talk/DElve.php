<?php
final class Seattle_DElve extends SR_TalkingNPC
{
	public function getName() { return 'Malois'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
// 		$b = chr(2);
		$key = 'Seattle_DElve_R';
		
		$quest = SR_Quest::getQuest($player, 'Seattle_IDS');
		if ($quest->isInQuest($player))
		{
			$quest->checkQuest($this, $player);
			if ($quest->isDone($player))
			{
				return $this->rply('innocent');
// 				$this->reply('Look innocent!');
// 				return;
			}
		}
		
		switch ($word)
		{
			case 'renraku':
				if (!$quest->isAccepted($player))
				{
// 					$msg = 'We urgently need to enter the Renraku building, but we have no ID cards. Could you organize 3 of them for me?';
					$player->setTemp($key, 1);
					return $this->rply('ren1');
				}
				elseif ($quest->isDone($player))
				{
					return $this->rply('thx');
// 					$msg = 'Thank you again for you help!'; 
				}
				else 
				{
					return $this->rply('ren2');
// 					$msg = 'Please hurry and bring me the cards. I really need them quick.';
				}
// 				break;
			
			case 'shadowrun':
				if (!$quest->isAccepted($player))
				{
					$this->rply('sr1');
// 					$msg = "You are a runner? ... Thank god, I could need one, as I have some problems involving {$b}Renraku{$b}.";
					$player->giveKnowledge('words', 'Renraku');
					return true;
				}
				else
				{
					return $this->rply('hello2');
// 					$msg = 'Hello chummer.';
				}
// 				break;
				
			case 'yes':
				if ($player->hasTemp($key))
				{
					$quest->accept($player);
					$player->unsetTemp($key);
					return $this->rply('accept');
// 					$msg = 'Great. I hope it won\'t take you too long.';
				}
				else
				{
					return $this->rply('your_name');
// 					$msg = 'What is your name?';
				}
// 				break;
				
			case 'no':
				if ($player->hasTemp($key))
				{
					$player->unsetTemp($key);
					return $this->rply('no1');
// 					$msg = 'Maybe you decide otherwise later. I will be here most time of the day.';
				}
				else
				{
					return $this->rply('no2');
// 					$msg = 'Laters, chummer.';
				}
// 				break;

			case 'magic':
				return $this->rply('magic');
// 				$msg = 'Magic... I almost lost all my essence due to the Renraku experiments. It was hard to recover from that.';
// 				break;
			
			default:
				return $this->rply('default');
// 				$msg = 'Hello chummer, my name is Malois. Take a seat and have a drink :(';
// 				break;
			
		}
// 		$this->reply($msg);
	}
}
?>