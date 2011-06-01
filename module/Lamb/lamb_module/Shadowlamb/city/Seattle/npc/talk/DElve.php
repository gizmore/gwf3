<?php
final class Seattle_DElve extends SR_TalkingNPC
{
	public function getName() { return 'Malois'; }
	public function onNPCTalk(SR_Player $player, $word)
	{
		$b = chr(2);
		$key = 'Seattle_DElve_R';
		
		$quest = SR_Quest::getQuest($player, 'Seattle_IDS');
		if ($quest->isInQuest($player)) {
			$quest->checkQuest($this, $player);
			if ($quest->isDone($player)) {
				$this->reply('Look innocent!');
				return;
			}
		}
		
		switch ($word)
		{
			case 'renraku':
				if (!$quest->isAccepted($player))
				{
					$msg = 'We urgently need to enter the Renraku building, but we have no ID cards. Could you organize 3 of them for me?';
					$player->setTemp($key, 1);
				}
				elseif ($quest->isDone($player))
				{
					$msg = 'Thank you again for you help!'; 
				}
				else 
				{
					$msg = 'Please hurry and bring me the cards. I really need them quick.';
				}
				break;
			
			case 'shadowrun':
				if (!$quest->isAccepted($player))
				{
					$msg = "You are a runner? ... Thank god, i could need one, as i have some problems involving {$b}Renraku{$b}.";
					$player->giveKnowledge('words', 'Renraku');
				}
				else
				{
					$msg = 'Hello chummer.';
				}
				break;
				
			case 'yes':
				if ($player->hasTemp($key))
				{
					$quest->accept($player);
					$player->unsetTemp($key);
					$msg = 'Great. I hope it won\'t take you too long.';
				}
				else
				{
					$msg = 'What is your name?';
				}
				break;
				
			case 'no':
				if ($player->hasTemp($key))
				{
					$player->unsetTemp($key);
					$msg = 'Maybe you decide otherwise later. I will be here most time of the day.';
				}
				else
				{
					$msg = 'Laters, chummer.';
				}
				break;

			case 'magic':
				$msg = 'Magic... i almost lost all my essence due to the Renraku experiments. It was hard to recover from that.';
				break;
			
			default:
				$msg = 'Hello chummer, my name is Malois. Take a seat and have a drink :(';
				break;
			
		}
		$this->reply($msg);
	}
}
?>