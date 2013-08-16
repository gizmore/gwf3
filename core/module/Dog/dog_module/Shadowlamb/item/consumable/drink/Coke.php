<?php
final class Item_Coke extends SR_Drink
{
	public function getItemLevel() { return 0; }
	public function getItemWeight() { return 425; }
	public function getLitres() { return 333; }
	public function getItemPrice() { return 1.23; }
	public function getItemDescription() { return '0.33 litres of Coca~Cola.'; }
//	public function isItemSellable() { return false; }
	public function onConsume(SR_Player $player)
	{
		$oldhp = $player->getHP();
		$gain = $player->healHP(0.20);
		$player->getParty()->notice(sprintf('%s drank a coke: %s.', $player->getName(), Shadowfunc::displayHPGain($oldhp, $gain, $player->getMaxHP())));
	}
}
?>