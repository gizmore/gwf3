<?php
final class Quest_Redmond_Barkeeper extends SR_Quest
{
	const REWARD_XP = 6;
	const REWARD_NY = 550;
	const NEED_SMALL_BEER = 12;
	const NEED_LARGE_BEER = 6;
	const NEED_BOOZE = 3;

	public function getQuestDescription()
	{
		$data = $this->getQuestData();
		$have_s = isset($data['S']) ? $data['S'] : 0;
		$have_l = isset($data['L']) ? $data['L'] : 0;
		$have_b = isset($data['B']) ? $data['B'] : 0;
		return sprintf(
			'Bring these items to the Barkeeper in Redmond_TrollsInn: %d/%d SmallBeer, %d/%d LargeBeer and %d/%d Booze.',
			$have_s, self::NEED_SMALL_BEER,
			$have_l, self::NEED_LARGE_BEER,
			$have_b, self::NEED_BOOZE
		);
	}
	
	public function onQuestSolve(SR_Player $player)
	{
		$player->message(sprintf('The barkeeper looks happy: "Now we have enough drinks for the party :)", he says.'));
		$player->message(sprintf('He hands you %s, and you also gained %d XP.', Shadowfunc::displayPrice(self::REWARD_NY), self::REWARD_XP));
		$player->giveXP(self::REWARD_XP);
		$player->giveNuyen(self::REWARD_NY);
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
		if ( ($have_s === self::NEED_SMALL_BEER) && ($have_l === self::NEED_LARGE_BEER) && ($have_b === self::NEED_BOOZE)) {
			$this->onSolve($player);
		}
		else {
			$npc->reply(sprintf('Listen chummer, i still need %d SmallBeer, %d LargeBeer and %d Booze.', self::NEED_SMALL_BEER-$have_s, self::NEED_LARGE_BEER-$have_l, self::NEED_BOOZE-$have_b));
		}
	}
	
	
}
?>