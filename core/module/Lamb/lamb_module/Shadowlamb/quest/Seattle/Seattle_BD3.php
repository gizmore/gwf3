<?php
final class Quest_Seattle_BD3 extends SR_Quest
{
	const NEED_LEG = 3;
	const NEED_ARMOR = 3;
	const NEED_HELMET = 4;
	
	const REWARD_XP = 4;
	const REWARD_NUYEN = 1500;
	
	public function getQuestName() { return 'PoorSmith3'; }
	public function getQuestDescription() { return sprintf('Bring %s ChainLegs, %s ChainBody and %s ChainHelmet to the Seattle Blacksmith.', self::NEED_LEG, self::NEED_ARMOR, self::NEED_HELMET); }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->isDone($player))
		{
			return false;
		}
		
		$data = $this->getQuestData();
		if (!isset($data['LEG'])) { $data = array('LEG'=>0,'ARMOR'=>0,'HELMET'=>0); }
		
		$data['LEG'] = $this->giveQuesties($player, $npc, 'ChainLegs', $data['LEG'], self::NEED_LEG);
		$data['ARMOR'] = $this->giveQuesties($player, $npc, 'ChainBody', $data['ARMOR'], self::NEED_ARMOR);
		$data['HELMET'] = $this->giveQuesties($player, $npc, 'ChainHelmet', $data['HELMET'], self::NEED_HELMET);
		
		$this->saveQuestData($data);
		
		$need_leg = self::NEED_LEG - $data['LEG'];
		$need_armor = self::NEED_ARMOR - $data['ARMOR'];
		$need_helmet = self::NEED_HELMET - $data['HELMET'];
		
		$need = array();
		if ($need_leg > 0)
		{
			$need[$need_leg.' ChainLegs'] = $need_leg;
		}
		if ($need_armor > 0)
		{
			$need[$need_armor.' ChainBodies'] = $need_armor;
		}
		if ($need_helmet > 0)
		{
			$need[$need_helmet.' ChainHelmets'] = $need_helmet;
		}
		
		if (count($need) === 0)
		{
			$npc->reply('Thank you very very much.');
			$npc->reply('Please take this as reward!');
			$player->message(sprintf('The dwarf hands you %s. You also gain %s XP.', Shadowfunc::displayNuyen(self::REWARD_NUYEN), self::REWARD_XP));
			$player->giveXP(self::REWARD_XP);
			$player->giveNuyen(self::REWARD_NUYEN);
			$this->onSolve($player);
		}
		else
		{
			$npc->reply(sprintf('I still need %s.', Common::implodeHuman(array_keys($need))));
		}
		return true;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word)
	{
		switch ($word)
		{
			case 'confirm':
				$npc->reply('It would be so great if you could help me again, yes?');
				break;
			case 'shadowrun':
				$npc->reply('Thanks to you i have some runes now, and the customers are already coming.');
				$npc->reply('However, i need Chain armory for the Arena and i have no time to smith it.');
				$npc->reply(sprintf('Could you bring me %s ChainLegs, %s ChainBodies and %s ChainHelmets?', self::NEED_LEG, self::NEED_ARMOR, self::NEED_HELMET));
				$npc->reply(sprintf('I can pay you %s for that job! Yes?', Shadowfunc::displayNuyen(self::REWARD_NUYEN)));
				break;
			case 'yes':
				$npc->reply(sprintf('Thank you so very much. Please hurry. The Arena frequently needs melee armory.'));
				break;
			case 'no':
				$npc->reply('Anyway check out my offers!');
				break;
		}
	}
}
?>
