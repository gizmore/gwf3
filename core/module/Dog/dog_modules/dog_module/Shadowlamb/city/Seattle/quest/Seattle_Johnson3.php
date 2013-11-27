<?php
final class Quest_Seattle_Johnson3 extends SR_Quest
{
// 	public function getQuestName() { return 'TheDebt'; }
// 	public function getQuestDescription() { return 'Ask the Blackmarket guy about the debt of Mr.Johnson in the Seattle_Deckers.'; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->giveQuesties($player, $npc, 'Collar', 0, 100) > 0)
		{
			$ny = 2000;
			$xp = 5;

			$player->message($this->lang('thx1'));
// 			$player->message('You hand the Collar to Mr.Johnson, "Here is something for you from Mogrid!"');
			$npc->reply($this->lang('thx2'));
// 			$npc->reply('Haha! Well done chummer. Let me check.');
			$player->message($this->lang('thx3'));
// 			$player->message('Mr.Johnson counts the money ...');
			$npc->reply($this->lang('thx4'));
// 			$npc->reply("Very well done chummer. Everything's there!");
			$player->message($this->lang('thx5', array($ny, $xp)));
// 			$player->message("He hands you {$ny} Nuyen and you also gain {$xp} XP.");
			
			$player->giveNuyen($ny);
			$player->giveXP($xp);
			$this->onSolve($player);
			return true;
		}
		
		$npc->reply($this->lang('more'));
// 		$npc->reply('Bring me the money, chummer, so I can give you a share.');
		return false;
	}
	
	public function dropCollar(SR_NPC $npc, SR_Player $player)
	{
		if (!$this->isInQuest($player))
		{
			return array();
		}
		$data = $this->getQuestData();
		if (isset($data['DROPPED']))
		{
			return array();
		}
		$data['DROPPED'] = 1;
		$this->saveQuestData($data);
		return array('Collar');
	}
}
?>
