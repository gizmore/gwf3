<?php
/**
 * Goth kill 10 emo
 * @author gizmore
 */
final class Quest_Delaware_MCGuest11 extends SR_Quest
{
// 	const EMO_TYPE = 'Emos';
// 	public function getQuestName() { return 'Emos'; }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
// 	public function getQuestDescription() { return sprintf('Kill %d / %d %s and return to the MacLarens pub.', $this->getAmount(), $this->getNeededAmount(), self::EMO_TYPE); }
	public function getNeededAmount() { return 10; }
	public function getRewardNuyen() { return 500; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getAmount();
		$need = $this->getNeededAmount();
		
		if ($have >= $need)
		{
			$npc->reply($this->lang('thx'));
// 			$npc->reply('Hell yeah!');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply($this->lang('more', array($need-$have)));
// 			return $npc->reply(sprintf("Please kill %d more %s.", $need-$have, self::EMO_TYPE));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		$dp = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1', array($need, $dp)));
// 				$npc->reply("God I hate emos ... Kill {$need} of em and I pay {$dp}?");
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm'));
// 				$npc->reply("God, Just kill em all.");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('God, Yeah.');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('God, ok.');
				break;
		}
		return true;
	}
	
	public function onKill(SR_Player $player)
	{
		if ($this->isInQuest($player))
		{
			$this->increaseAmount(1);
			$player->message($this->lang('kill', array($this->getAmount(), $this->getNeededAmount(), $this->getQuestName())));
// 			$player->message(sprintf("Now you killed %d of %d %s for the %s quest.", $this->getAmount(), $this->getNeededAmount(), self::EMO_TYPE, $this->getQuestName()));
		}
	}
}
?>
