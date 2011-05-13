<?php
final class Seattle_Archer extends SR_TalkingNPC
{
	public function getName() { return 'Jonathan'; }
	public function getNPCModifiers() { return array('race' => 'human'); }
	
	public function onNPCTalk(SR_Player $player, $word)
	{
		$b = chr(2);
		$quest = SR_Quest::getQuest($player, 'Seattle_Archery');
		$quest->checkQuest($this, $player);
		
		$key = "SEATTLE_ARCHER_QUEST_T";
		switch ($word)
		{
			case 'bow': $msg = "The bow is a silent weapon. The bow skill increase your attack and damage for bows."; break;
			
			case 'shadowrun':
				
				if ($player->hasTemp($key))
				{
					$msg = "Can you help us?";
					$player->unsetTemp($key);
				}
				elseif ($quest->isDone($player))
				{
					$msg = 'Thank you again for your help. There has not been an attack on citizens yet again!';
				}
				elseif ($quest->isInQuest($player))
				{
					$msg = 'Please punish some more of the Angry Elves.';
				}
				else
				{
					$msg1 = 'You could do us a favor... Some of the elves in our school got angry, and attacked citizens.';
					$msg = 'Could you please loot some of them, so maybe these dölmers think twice before breaking the laws?';
					$this->reply($msg1);
					$player->setTemp($key, 1);
				}
				break;
				
			case 'yes':
				
				if ($player->hasTemp($key))
				{
					$quest->accept($player);
					$player->unsetTemp($key);
					$msg = 'We await your success.';
				}
				else { return; }
				break;

			case 'no':

				if ($player->hasTemp($key))
				{
					$player->unsetTemp($key);
					$msg = 'We wait for the next newbie runner who might accept this quest.';
				}
				else { return; }
				break;
				
				
			default: $msg = "Hello, welcome to the seattle archery. Have fun with the range. Also feel free to visit our shop or {$b}learn{$b} the skill of {$b}bow{$b}."; break;
		}
		$this->reply($msg);
	}
	
}
?>