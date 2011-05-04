<?php
final class Item_Bacon extends SR_Consumable
{
	public function getItemLevel() { return -1; }
	public function getItemDescription() { return 'Some pork bacon. Smells weird. You wonder if it\'s still tasty.'; }
	public function getItemWeight() { return 200; }
	public function getItemUseTime(){ return 40; }
	public function getItemPrice() { return 2.95; }
	
	public function onConsume(SR_Player $player)
	{
		$oldhp = $player->getHP();
		$gain = $player->healHP(rand(5,8));
		$player->getParty()->message($player, 'ate some bacon. '.Shadowfunc::displayHPGain($oldhp, $gain, $player->getMaxHP()));
	}
	
}
?>