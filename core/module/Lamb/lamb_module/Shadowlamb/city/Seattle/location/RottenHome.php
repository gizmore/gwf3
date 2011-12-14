<?php
final class Seattle_RottenHome extends SR_SearchRoom
{
	public function getFoundText(SR_Player $player) { return "You found a rottom home and hear a weird monologue from the inside."; }
	public function getEnterText(SR_Player $player) { return "The front door is open and you sneak in. There is a crazy man on the floor."; }
	public function getFoundPercentage() { return 20.00; }
	public function getNPCS(SR_Player $player) { return array('talk'=>'Seattle_TomRiddle'); }
	
	public function getSearchMaxAttemps() { return 1; }
	public function getSearchLevel() { return 0; }
	public function getSearchLoot(SR_Player $player)
	{
		if (0 !== SR_PlayerVar::getVal($player, '__WCSLC2', 0))
		{
			return array();
		}
		$player->message(sprintf('You search the garbage of Tom\'s habitat and find some interesting scrolls.'));
		SR_PlayerVar::setVal($player, '__WCSLC2', 1);
		return array(SR_Item::createByName('TomsScroll1'), SR_Item::createByName('TomsScroll2'), SR_Item::createByName('TomsScroll3'));
	}
}
?>