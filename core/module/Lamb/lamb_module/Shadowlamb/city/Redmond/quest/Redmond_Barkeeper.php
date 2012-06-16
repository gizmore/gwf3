<?php
final class Quest_Redmond_Barkeeper extends SR_Quest
{
	const NEED_SMALL_BEER = 12;
	const NEED_LARGE_BEER = 6;
	const NEED_BOOZE = 3;
	
	public function getRewardXP() { return 6; }
	public function getRewardNuyen() { return 550; }
	
	public function getQuestDescription()
	{
		$data = $this->getQuestData();
		$have_s = isset($data['S']) ? $data['S'] : 0;
		$have_l = isset($data['L']) ? $data['L'] : 0;
		$have_b = isset($data['B']) ? $data['B'] : 0;
		
		return $this->lang('descr', array(
			$have_s, self::NEED_SMALL_BEER,
			$have_l, self::NEED_LARGE_BEER,
			$have_b, self::NEED_BOOZE
		));
	}
	
	public function onQuestSolve(SR_Player $player)
	{
		$player->message($this->lang('solve1'));
		$player->message($this->lang('solve2', array($this->displayRewardNuyen(), $this->getRewardXP())));
// 		$player->message(sprintf('The barkeeper looks happy: "Now we have enough drinks for the party :)", he says.'));
// 		$player->message(sprintf('He hands you %s, and you also gained %d XP.', Shadowfunc::displayNuyen(self::REWARD_NY), self::REWARD_XP));
		return true;
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getQuestData();
		$have_s = isset($data['S']) ? $data['S'] : 0;
		$have_l = isset($data['L']) ? $data['L'] : 0;
		$have_b = isset($data['B']) ? $data['B'] : 0;
		$have_s = $this->giveQuesties($player, $npc, 'SmallBeer', $have_s, self::NEED_SMALL_BEER);
		$have_l = $this->giveQuesties($player, $npc, 'LargeBeer', $have_l, self::NEED_LARGE_BEER);
		$have_b = $this->giveQuesties($player, $npc, 'Booze', $have_b, self::NEED_BOOZE);
		$data = array('S'=>$have_s,'L'=>$have_l,'B'=>$have_b);
		$this->saveQuestData($data);
		if ( ($have_s >= self::NEED_SMALL_BEER) && ($have_l >= self::NEED_LARGE_BEER) && ($have_b >= self::NEED_BOOZE))
		{
			$this->onSolve($player);
		}
		else
		{
			$npc->reply($this->lang('listen', array(self::NEED_SMALL_BEER-$have_s, self::NEED_LARGE_BEER-$have_l, self::NEED_BOOZE-$have_b)));
// 			$npc->reply(sprintf('Listen chummer, I still need %d SmallBeer, %d LargeBeer and %d Booze.', self::NEED_SMALL_BEER-$have_s, self::NEED_LARGE_BEER-$have_l, self::NEED_BOOZE-$have_b));
			$this->sendStatusUpdate($player);
		}
		return true;
	}
}
?>
