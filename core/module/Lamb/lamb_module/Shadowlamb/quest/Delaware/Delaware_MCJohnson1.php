<?php
final class Quest_Delaware_MCJohnson1 extends SR_Quest
{
	const KILLS_NEEDED = 17;
	
	public function getQuestName() { return 'Scene'; }
	public function getQuestDescription()
	{
		$kn = self::KILLS_NEEDED;
		$data = $this->getKillData();
		return sprintf(
			'Kill %d / %d Hipster, %d / %d Emos and %d / %d Goths and return to Mr.Johnson in the MacLarens pub.',
			$data['H'], $kn, $data['E'], $kn, $data['G'], $kn
		);
	}
	public function getNeededAmount() { return 10; }
	public function getRewardXP() { return 10; }
	public function getRewardNuyen() { return 1500; }
	
	public function getKillData()
	{
		$data = $this->getQuestData();
		if (!isset($data['H'])) $data['H'] = 0;
		if (!isset($data['E'])) $data['E'] = 0;
		if (!isset($data['G'])) $data['G'] = 0;
		return $data;
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getKillData();
		$kh = $data['H'];
		$kg = $data['G'];
		$ke = $data['E'];
		
		if ( ($kh >= self::KILLS_NEEDED) && ($kg >= self::KILLS_NEEDED) && ($ke >= self::KILLS_NEEDED) )
		{
			$npc->reply('You are doing a good job, chummer.');
			$this->onSolve($player);
		}
		else
		{
			$nh = Common::clamp(self::KILLS_NEEDED-$kh, 0);
			$ng = Common::clamp(self::KILLS_NEEDED-$kg, 0);
			$ne = Common::clamp(self::KILLS_NEEDED-$ke, 0);
			return $npc->reply(sprintf('Please kill %d more Hipster, %d more Emo and %d more Goth, then we talk again.', $nh, $ne, $ng));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$kn = self::KILLS_NEEDED;
		$dp = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				if (count($args) === 1)
				{
					return $this->onAnswer($npc, $player, $args[0]);
				}
				$npc->reply("Lol these scene people are funny ... Everyone hates everyone.");
				$npc->reply("There are three groups of scene people: Goth, Emo and Hipster.");
				$npc->reply("Every group wants to get $kn of every other group killed.");
				$npc->reply("How many kills are requested in total?");
				$npc->reply("Lol if you can #ttj shadowrun <answer> me the number you get the job.");
				return false;
				break;
			case 'confirm':
				$npc->reply("I will pay you $dp.");
				break;
			case 'yes':
				$npc->reply("Good luck hunting!");
				break;
			case 'no':
				$npc->reply('Hmm ok, maybe later.');
				break;
		}
		return true;
	}
	
	public function onAnswer(SR_TalkingNPC $npc, SR_Player $player, $answer)
	{
		if ($player->get('math') > 0)
		{
			$npc->reply('Haha ... With your insane math skills you don\'t even need to answer. Do you accept the job?');
			return true;
		}
		
		$solution = self::KILLS_NEEDED * 6;
		if ($answer == $solution)
		{
			$npc->reply('Correct. Do you accept the job?');
			return true;
		}
		else
		{
			$npc->reply('Lol just sum some values chummer?');
			return false;
		}
	}

	# KILL
	public function onKillEmo(SR_Player $player) { $this->onKill($player, 'E', 'Emos'); }
	public function onKillGoth(SR_Player $player) { $this->onKill($player, 'G', 'Goths'); }
	public function onKillHipster(SR_Player $player) { $this->onKill($player, 'H', 'Hipsters'); }
	public function onKill(SR_Player $player, $key, $name)
	{
		if (!$this->isInQuest($player))
		{
			return;
		}
		$data = $this->getKillData();
		$data[$key]++;
		$player->message(sprintf("Now you killed %d of %d %s for Mr.Johnson in the MacLarens pub.", $data[$key], self::KILLS_NEEDED, $name));
		$this->saveQuestData($data);
	}
}
?>
