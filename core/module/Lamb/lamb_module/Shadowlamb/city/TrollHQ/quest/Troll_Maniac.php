<?php
final class Quest_Troll_Maniac extends SR_Quest
{
	const NEED_SMALL = 5;
	const NEED_LARGE = 3;
	const NEED_ELVEN = 2;
	const NEED_KEVLAR = 1;
	
	public function getQuestName() { return 'TrollManiac'; }
	public function getRewardXP() { return 6; }
	public function getRewardNuyen() { return 1200; }
	public function getQuestDescription()
	{
		$data = $this->getTrollManiacData();
		return
			sprintf('Bring %d/%d SmallShield, %d/%d LargeShield, %d/%d ElvenShield and %d/%d KevlarShield to Larry, your Troll chief.',
				$data['S'], self::NEED_SMALL, $data['L'], self::NEED_LARGE, $data['E'], self::NEED_ELVEN, $data['K'], self::NEED_KEVLAR
			);
	}
	
	
	private function getTrollManiacData()
	{
		$data = $this->getQuestData();
		if (!isset($data['S'])) { $data['S'] = 0; }
		if (!isset($data['L'])) { $data['L'] = 0; }
		if (!isset($data['E'])) { $data['E'] = 0; }
		if (!isset($data['K'])) { $data['K'] = 0; }
		return $data;
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getTrollManiacData();
		
		$have_small = $this->giveQuesties($player, $npc, 'SmallShield', $data['S'], self::NEED_SMALL);
		$have_large = $this->giveQuesties($player, $npc, 'LargeShield', $data['L'], self::NEED_LARGE);
		$have_elven = $this->giveQuesties($player, $npc, 'ElvenShield', $data['E'], self::NEED_ELVEN);
		$have_kevlar = $this->giveQuesties($player, $npc, 'KevlarShield', $data['K'], self::NEED_KEVLAR);

		$data['S'] = $have_small;
		$data['L'] = $have_large;
		$data['E'] = $have_elven;
		$data['K'] = $have_kevlar;

		$this->saveQuestData($data);
		
		if ( 
			($have_small>=self::NEED_SMALL) &&
			($have_large>=self::NEED_LARGE) &&
			($have_elven>=self::NEED_ELVEN) &&
			($have_kevlar>=self::NEED_KEVLAR))
		{
			$npc->reply('We thank you very much. Please come with me.');
			$this->onTrollReward($npc, $player);
			return $this->onSolve($player);
		}
		else
		{
			$npc->reply('We need more shield for the army');
		}
		return false;
	}
	
	private function onTrollReward(SR_NPC $npc, SR_Player $player)
	{
		$max = $player->isRunner() ? Shadowcmd_lvlup::MAX_VAL_ATTRIBUTE_RUNNER : Shadowcmd_lvlup::MAX_VAL_ATTRIBUTE;
		$base = $player->getBase('magic');
		
		if ($base >= $max)
		{
			$player->giveNuyen(5000);
			return $player->message('Larry hands you another 5000 nuyen!');
		}
		
		$player->message('Larry leads you to a shamane: "This is our shamane, Srando, he can help you."');
		
		$race = $player->getRace();
		
		if ( ($race === 'Ork') || ($race === 'Troll') )
		{
			$player->message('The shamane says: "You are a strong '.$race.'. You just need to calm down sometime."');
			$player->message('You are starting to argue, but the shamane continues: "If you calm you have more time to strengthen yourself. Focus yourself, and the path is clear."');
			$player->message('The shamane touches your head: "Your mind is now clear from anything. You can focus yourself from now on."');
			$player->message('Your character is now allowed to learn magic and spells.');
		}
		else 
		{
			$player->message('The shamane mumbles some magic spells and raises your base value for magic by 1.');
		}
		
		$player->alterField('magic', 1);
		$player->modify();
		
		return true;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$dp = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("You are the best. If you can help us an last time we will help you big.");
				$npc->reply(sprintf('Bring %d SmallShield, %d LargeShield, %d ElvenShield, and %d KevlarShield so I can create better army.', self::NEED_SMALL, self::NEED_LARGE, self::NEED_ELVEN, self::NEED_KEVLAR));
				$npc->reply('Shamane will reward you well!');
				break;
			case 'confirm':
				$npc->reply("Go!");
				break;
			case 'yes':
				$npc->reply("Thank you!");
				break;
			case 'no':
				$npc->reply('You should do it.');
				break;
		}
		return true;
	}
}
?>