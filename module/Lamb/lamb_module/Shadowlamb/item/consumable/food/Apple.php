<?php
final class Item_Apple extends SR_Food
{
	public function getItemLevel() { return 2; }
	public function getItemDescription() { return 'A green apple. Edible.'; }
	public function getItemWeight() { return 300; }
	public function getItemUseTime(){ return 80; }
	public function getItemPrice() { return 0.75; }
	
	public function onConsume(SR_Player $player)
	{
		$oldhp = $player->getHP();
		$gain = $player->healHP(Shadowfunc::diceFloat(0.3, 0.7, 1));
		$player->getParty()->message($player, 'ate some bacon. '.Shadowfunc::displayHPGain($oldhp, $gain, $player->getMaxHP()));
	}
	
}
?>