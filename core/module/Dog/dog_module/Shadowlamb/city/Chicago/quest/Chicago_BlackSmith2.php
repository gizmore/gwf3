<?php
final class Quest_Chicago_BlackSmith2 extends SR_QuestMultiItem
{
	public function getQuestDataItems(SR_Player $player)
	{
		return array(
			'SmallAxe' => 1,
			'Axe' => 1,
			'LargeAxe' => 1,
			'BattleAxe' => 1,
			'DaneAxe' => 1,
			'HaukAxe' => 1,
			'OldAxe' => 1,
			'Hellebard' => 1,
		);
	}
	
	public function getQuestName() { return 'TheAxeEffect'; }
	public function getQuestDescription() { return parent::getQuestDescriptionMI('Bring %1$s to the Blacksmith in Chicago.'); }
	public function getRewardXP() { return 7; }
	public function getRewardNuyen() { return 1400; }
	public function onQuestMIGiven($npc, SR_Player $player) { $npc->reply("Thanks ... *hick* chummer!"); }
	public function onQuestMIMore($npc, SR_Player $player) { $npc->reply('I need *hick* more Axe'); }
	public function onQuestMISolved($npc, SR_Player $player) { $npc->reply("Wows great job *hick*"); }
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$ny = $this->getRewardNuyen();
		$dny = Shadowfunc::displayNuyen($ny);
		
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply(sprintf("Chummer, I am collecting axes for selling bundles and my own repositry."));
				$npc->reply(self::getQuestDescriptionMI("I need %s for a complete bundle, can you help for {$dny}?"));
				break;
			case 'confirm':
				$npc->reply("Can you help?");
				break;
			case 'yes':
				$npc->reply('Thank you chummer!');
				break;
			case 'no':
				$npc->reply('Fine then.');
				break;
		}
		return true;
	}
}
?>
