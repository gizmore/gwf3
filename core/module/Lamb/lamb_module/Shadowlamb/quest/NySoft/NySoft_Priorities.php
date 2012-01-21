<?php
final class Quest_NySoft_Priorities extends SR_QuestMultiItem
{
	public function getQuestDataItems(SR_Player $player)
	{
		return array(
			'Pizza' => 6,
			'Coke' => 8,
			'SmallBeer' => 6,
		);
	}
	public function getRewardXP() { return 6; }
	public function getRewardNuyen() { return 600; }
	public function getQuestName() { return 'Priorities'; }
	public function getQuestDescription() { return parent::getQuestDescriptionMI('Bring %1$s to Christian in the NySoft office, Deleware.'); }
	public function onQuestMIGiven($npc, SR_Player $player) { $npc->reply("Thanks chummer!"); }
	public function onQuestMIMore($npc, SR_Player $player) { $npc->reply('Where are our supplies?'); }
	public function onQuestMISolved($npc, SR_Player $player) { $npc->reply("Finally i can get back to work!"); }
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		$ny = $this->getRewardNuyen();
		$dny = Shadowfunc::displayNuyen($ny);
		
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Oh well ... you can support us with supplies, so we can get back to work.");
				$npc->reply("Interested?");
				break;
			case 'confirm':
				$npc->reply("So?");
				break;
			case 'yes':
				$npc->reply('Thank you chummer.');
				break;
			case 'no':
				$npc->reply('Laters chummer.');
				break;
		}
		return true;
	}
}
?>