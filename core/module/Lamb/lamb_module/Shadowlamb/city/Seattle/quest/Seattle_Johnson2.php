<?php
final class Quest_Seattle_Johnson2 extends SR_Quest
{
	public function getNeededAmount() { return 15; }

// 	public function getQuestName() { return 'TheContractor2'; }
// 	public function getQuestDescription() { return sprintf('Bring %s/%s IDCards to Mr.Johnson in the Deckers Pub.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	
	private $xp = 10;
	private $nuyen = 3500;
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'IDCard', $have, $need);
		$this->saveVar('sr4qu_amount', $have);
		if ($have >= $need)
		{
			$npc->reply($this->lang('thx1'));
// 			$npc->reply('You are the best. Our customer pays well. Here chummer, thats for you.');
			$player->message($this->lang('thx2', array($this->nuyen, $this->xp)));
// 			$player->message(sprintf('Mr.Johnson hands you %s Nuyen. You also gained %s XP.', $this->nuyen, $this->xp));
			$player->giveNuyen($this->nuyen);
			$player->giveXP($this->xp);
			$this->onSolve($player);
		}
		else
		{
			$npc->reply($this->lang('more', array($have, $need)));
// 			$npc->reply(sprintf('You gave me %s of %s IDCards. Please bring me some more.', $have, $need));
		}
	}
}
?>
