<?php
final class Quest_Seattle_Florist1 extends SR_Quest
{
	public function getQuestDescription() { return $this->lang('descr', array(Shadowlang::displayItemnameS('BlackOrchid'), Shadowlang::displayItemnameS('WhiteOrchid'))); }
	
	public function getTrigger() { return 'love'; }
	public function getQuestTriggers() { return array('loved', 'banshee', 'banshees', 'blackorchid', 'blackorchids', 'orchid', 'orchids'); }
	
	public function getRewardXP() { return 10; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$given = $this->giveQuesties($player, $npc, 'BlackOrchid', 0, 1);
		
		if ($given > 0)
		{
			if (rand(0,4) === 0)
			{
				$npc->reply($this->lang('yay1'));
				$player->message($this->lang('yay2'));
				$player->giveItems(SR_Item::createByName('WhiteOrchid'), $npc->getName());
				if ($this->isInQuest($player))
				{
					$this->onSolve($player);
				}
			}
			else
			{
				$npc->reply($this->lang('aww'));
			}
		}
		else
		{
			$npc->reply($this->lang('more'));
		}
		
		return true;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		echo "HERE\n";
		$temp = 'QT_LILLY';
		
		switch ($word)
		{
			default:
				$t = $player->getTemp($temp, 0);
				$player->setTemp($temp, $t+1);
				echo "HERE $t\n";
				switch ($t)
				{
					case 0:
						$npc->reply($this->lang('sr1'));
						$npc->reply($this->lang('sr2'));
						return false;
					case 1:
						$npc->reply($this->lang('sr3'));
						$npc->reply($this->lang('sr4'));
						return false;
					case 2:
						$npc->reply($this->lang('sr5'));
						$npc->reply($this->lang('sr6'));
					default:
						return $npc->reply($this->lang('confirm'));
				}
				
			case 'confirm': return $npc->reply($this->lang('confirm'));
			case 'yes': return $npc->reply($this->lang('yes'));
			case 'no': return $npc->reply($this->lang('no'));
		}
	}
}
?>
