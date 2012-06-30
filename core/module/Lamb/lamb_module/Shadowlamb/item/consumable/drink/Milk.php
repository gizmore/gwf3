<?php
final class Item_Milk extends SR_Drink
{
	public function getItemLevel() { return 4; }
	public function getItemWeight() { return 520; }
	public function getItemPrice() { return 2.95; }
	public function getItemDescription() { return 'A half litre of fresh milk.'; }
	public function onConsume(SR_Player $player)
	{
		$oldhp = $player->getHP();
		$gain = $player->healHP(0.4);
		$player->getParty()->notice(sprintf('%s drank a half litre of milk %s.', $player->getName(), Shadowfunc::displayHPGain($oldhp, $gain, $player->getMaxHP())));
	}
}
?>
