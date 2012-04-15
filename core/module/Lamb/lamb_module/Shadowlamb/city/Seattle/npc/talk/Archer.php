<?php
final class Seattle_Archer extends SR_TalkingNPC
{
	public function getName() { return 'Jonathan'; }
	public function getNPCModifiers() { return array('race' => 'human'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		$quest = SR_Quest::getQuest($player, 'Seattle_Archery');
		if ($quest->checkQuest($this, $player)) {
			return true;
		}
		
		$key = "SEATTLE_ARCHER_QUEST_T";
		switch ($word)
		{
			case 'bow':
				return $this->rply($word);
// 				$msg = "The bow is a silent weapon. The bow skill increase your attack and damage for bows.";
// 				break;
			
			case 'shadowrun':
				
				if ($player->hasTemp($key))
				{
// 					$player->unsetTemp($key);
					return $this->rply('sr1');
// 					$msg = "Can you help us?";
				}
				elseif ($quest->isDone($player))
				{
					return $this->rply('sr2');
// 					$msg = 'Thank you again for your help. There has not been an attack on citizens yet again!';
				}
				elseif ($quest->isInQuest($player))
				{
					return $this->rply('sr3');
// 					$msg = 'Please punish some more of the Angry Elves.';
				}
				else
				{
					$this->rply('sr4');
// 					$msg1 = 'You could do us a favor... Some of the elves in our school got angry, and attacked citizens.';
					$this->rply('sr5');
// 					$msg = 'Could you please loot some of them, so maybe these dölmers think twice before breaking the laws?';
					$player->setTemp($key, 1);
					return true;
				}
// 				break;
				
			case 'yes':
				
				if ($player->hasTemp($key))
				{
					$quest->accept($player);
					$player->unsetTemp($key);
// 					$msg = 'We await your success.';
					return $this->rply('yes2');
				}
				else
				{
					return $this->rply('yes1');
				}

			case 'no':

				if ($player->hasTemp($key))
				{
					$player->unsetTemp($key);
					return $this->rply('no2');
// 					$msg = 'We wait for the next newbie runner who might accept this quest.';
				}
				else
				{
					return $this->rply('no1');
				}
// 				break;
				
			case 'malois':
				return $this->rply($word);
// 				$msg = 'What are you talking about?'; break;
				
			default:
				return $this->rply('default');
// 				$msg = "Hello, welcome to the seattle archery. Have fun with the range. Also feel free to visit our shop or {$b}learn{$b} the skill of {$b}bow{$b}."; break;
		}
// 		return $this->reply($msg);
	}
}
?>
