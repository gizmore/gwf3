<?php
final class Quest_Seattle_GJohnson3 extends SR_Quest
{
	const REWARD_XP = 2;
	const REWARD_NUYEN = 1200;

	public function getNeededAmount() { return 1; }
	
// 	public function getQuestName() { return 'KnownContent'; }
// 	public function getQuestDescription() { return sprintf('Bring the RenrakuPackage to the Renraku_Bureau.'); }
	
	public function givePackage(SR_NPC $npc, SR_Player $player)
	{
		if ($this->giveQuesties($player, $npc, 'RenrakuPackage', 0, 1) > 0)
		{
			$player->message($this->lang('hand1'));
// 			$player->message('You hand the package to the employee.');
			$this->saveAmount(1);
			$npc->reply($this->lang('hand2'));
// 			$npc->reply('Thank you, sire. We have been waiting for this delivery.');
			return true;
		}
		return false;
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->isDone($player))
		{
			return false;
		}
		
		if ($this->getAmount() > 0)
		{
			$npc->reply($this->lang('thx1'));
// 			$npc->reply('Yes I confirm you have delivered the package. Good job. Here is your reward and a small bonus.');
			$ny = Shadowfunc::displayNuyen(self::REWARD_NUYEN);
			$xp = self::REWARD_XP;
			$player->message($this->lang('thx2', array($ny, $xp)));
// 			$player->message(sprintf('Mr.Johnson hands you a couvert with %s. You also gain %s XP.', $ny, $xp));
			$player->giveNuyen(self::REWARD_NUYEN);
			$player->giveXP(self::REWARD_XP);
			$this->onSolve($player);
			return true;
		}
		else
		{
			$npc->reply($this->lang('more'));
// 			$npc->reply(sprintf('Better deliver the package chummer.'));
			return true;
		}
	}
	
	public function onAccept(SR_Player $player)
	{
		$player->giveItems(array(SR_Item::createByName('RenrakuPackage')), 'Mr.Johnson');
	}
	
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
				$npc->reply($this->lang('sr2'));
// 				$npc->reply('Yo chummer, I could need you to deliver a package to the Renraku office ... You know ... The Cardgame.');
// 				$npc->reply('Do you accept?');
				break;
			
			case 'confirm':
				$ny = Shadowfunc::displayNuyen(self::REWARD_NUYEN-200);
				$npc->reply($this->lang('confirm', array($ny)));
// 				$npc->reply(sprintf('I will pay you %s for this run.', $ny));
				break;
				
			case 'no':
			case 'yes':
				$npc->reply($this->lang($word));
// 				$npc->reply(sprintf('Yeah chummer.'));
				break;
		}
		return true;
	}
	
}
?>
