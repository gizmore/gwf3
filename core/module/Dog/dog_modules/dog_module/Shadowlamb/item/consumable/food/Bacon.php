<?php
final class Item_Bacon extends SR_Food
{
	public function getItemLevel() { return -1; }
	public function getItemDescription() { return 'Some pork bacon. Smells weird. You wonder if it\'s still tasty.'; }
	public function getItemWeight() { return 200; }
	public function getWater() { return 30; }
	public function getCalories() { return 800; }
	public function getItemUseTime(){ return 40; }
	public function getItemPrice() { return 2.95; }
	
	public function onConsume(SR_Player $player)
	{
		$oldhp = $player->getHP();
		$gain = $player->healHP(Shadowfunc::diceFloat(1.0, 3.0, 1));
		$player->getParty()->message($player, 'ate some bacon. '.Shadowfunc::displayHPGain($oldhp, $gain, $player->getMaxHP()));
	}
}
?>