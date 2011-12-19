<?php
final class Quest_Seattle_Barkeeper extends SR_Quest
{
	public function getQuestName() { return 'TheParty'; }
	public function getNeededAmount() { return 20; } 
	public function getQuestDescription() { return sprintf('Invite %s/%s Citizens to the Deckers party, then return to the pub and talk with the barkeeper.', $this->getAmount(), $this->getNeededAmount()); }
	
	public function onInviteCitizen(SR_NPC $npc, SR_Player $player, $amt=1)
	{
		$this->increase('sr4qu_amount', $amt);
		$player->message(sprintf('Now you have invited %s of %s citizens to the Deckers party.', $this->getAmount(), $this->getNeededAmount()));
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$need = $this->getNeededAmount();
		$have = $this->getAmount();
		if ($have >= $need)
		{
			$this->onSolve($player);
		}
		else
		{
			$npc->reply('Please invite more guests. The party is on friday. Which rockband should I take?');
		}
	}
	
	public function onQuestSolve(SR_Player $player)
	{
		$xp = 6;
		$ny = 1000;
		$player->message(sprintf('The barkeeper hands you %s Nuyen and smiles: "Good job. We surely will have more guests now.". You also gain %s XP.', $ny, $xp));
		$player->giveNuyen($ny);
		$player->giveXP($xp);
		$player->message(sprintf('Here, take this as a bonus reward. Guests forgot these items lately.'));
		$player->giveItems(Shadowfunc::randLootNItems($player, 15, 2));
	}
}
?>