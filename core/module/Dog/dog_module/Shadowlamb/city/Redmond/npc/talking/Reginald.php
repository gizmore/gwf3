<?php
final class Redmond_Reginald extends SR_TalkingNPC
{
	public function getName() { return 'Reginald'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		$quest = SR_Quest::getQuest($player, 'Redmond_Orks');
		
		if ($quest->isDone($player))
		{
			if ($word === 'shadowrun')
			{
				$this->rply('sr1');
// 				$this->reply("I am sorry but I don`t have another job for you... Maybe ask Mr.Johnson over there ;)");
			}
			else
			{
				$this->rply('sr2');
// 				$this->reply("Welcome back my friend! Thank you again for your help. Take a seat and have a drink :)");
			}
		}
		
		elseif ($quest->isAccepted($player))
		{
			if (1 === $quest->giveQuesties($player, $this, 'Reginalds_Bracelett', 0, 1, true))
			{
				$quest->onSolve($player);
				$this->rply('thx');
// 				$this->reply("Thank you so very much!");
			}
			else
			{
				$this->rply('aww1');
// 				$this->reply("I see you don`t have the bracelett for me :( ... But there is no need to hurry :)");
			}
			
		}
		
		elseif ($player->hasTemp('reginald_yes'))
		{
			if ($word === 'yes')
			{
				$this->rply('yes1');
// 				$this->reply("Thank you so very very much. I put all my trust in you... Go kill those bastards!");
				$quest->accept($player);
			}
			elseif ($word === 'no')
			{
				$this->rply('no1');
// 				$this->reply("I don`t accept no as an answer, Noob!");
			}
			else
			{
				$this->rply('aww2');
// 				$this->reply("You would do us a favor when you kill the OrkLeader :(");
			}
		}
		
		elseif ($player->hasTemp('reginald_hello'))
		{
			if ($word === 'yes')
			{
				$this->rply('run1');
				$this->rply('run2');
				$this->rply('run3');
				$this->rply('run4');
// 				$this->reply('Great, I have a delicate problem...');
// 				$this->reply('A few days ago our family got robbed by orks. They also stole my wifes bracelett... It is payback time and I want you to kill their leader.');
// 				$this->reply('As a proof of your success, you have to bring me the bracelett back. I will pay you well.');
// 				$this->reply('What do you say, chummer?');
				$player->setTemp('reginald_yes', true);
			}
			elseif ($word === 'no')
			{
				$this->rply('no2');
// 				$this->reply("Aww... I need a shadowrunner to get a job done. I would pay well... What do you say?");
			}
			elseif ($word === 'shadowrun')
			{
				$this->rply('runner');
// 				$this->reply('Please answer my question, it is urgent. Are you a runner?');
			}
			else
			{
				$this->rply('hello');
// 				$this->reply("Hello my name is Reginald. Are you a {$b}shadowrun{$b}ner?");
			}
		}
		
		else
		{
			$this->rply('hello');
// 			$this->reply("Hello my name is Reginald. Are you a {$b}shadowrun{$b}ner?");
			$player->giveKnowledge('words', 'Shadowrun', 'Yes', 'No');
			$player->setTemp('reginald_hello', true);
		}
	}
}
?>