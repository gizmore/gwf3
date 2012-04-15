<?php
final class Seattle_DElve2 extends SR_TalkingNPC
{
	public function getName() { return 'Malois'; }
	public function getNPCQuests(SR_Player $player) { return array('Seattle_Malois2'); }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		if ($this->onNPCQuestTalk($player, $word))
		{
			return true;
		}
		$quest1 = SR_Quest::getQuest($player, 'Renraku_I');
		$quest2 = SR_Quest::getQuest($player, 'Renraku_II');
		
		switch ($word)
		{
			case 'experiment':
			case 'experiments':
				$this->rply('experiments');
// 				$this->reply("I am sure in the upper floors of the Renraku building we can find out what exactly happend.");
				if (!$quest2->isAccepted($player))
				{
					$quest2->accept($player);
				}
				return true;
				
			case 'renraku':
			default:
				if ($quest1->isInQuest($player))
				{
					$this->rply('renraku1');
// 					$this->reply("Thank you for your help. Me and some friends will soon break into the Renraku office, and find out more.");
					$this->rply('renraku2');
// 					$this->reply("We know there are a lot of people involved in the {$b}experiments{$b}, and they do everything to keep it secret.");
					$this->rply('renraku3');
					$this->reply("Almost none of the victims remember anything. Some of them got serious brain damage, or even died.");
					$quest1->onSolve($player);
				}
				$this->rply('renraku4');
// 				$this->reply("I hope we will soon find out what happened in their {$b}experiments{$b}!");
				return true;
		}
	}
}
?>
