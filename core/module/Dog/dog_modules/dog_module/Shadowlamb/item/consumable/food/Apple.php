<?php
final class Item_Apple extends SR_Food
{
	public function getItemLevel() { return 2; }
	public function getItemDescription() { return 'A green apple. Edible.'; }
	public function getItemWeight() { return 250; }
	public function getWater() { return 50; }
	public function getCalories() { return 50; }
	public function getItemUseTime(){ return 70; }
	public function getItemPrice() { return 0.75; }
	
	public function onConsume(SR_Player $player)
	{
		$oldhp = $player->getHP();
		$gain = $player->healHP(Shadowfunc::diceFloat(0.2, 0.5, 1));
		$player->getParty()->message($player, 'ate an apple. '.Shadowfunc::displayHPGain($oldhp, $gain, $player->getMaxHP()));
	}
	
}
?>