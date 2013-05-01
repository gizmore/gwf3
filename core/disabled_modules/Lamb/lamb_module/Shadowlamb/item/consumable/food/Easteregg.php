<?php
final class Item_Easteregg extends SR_Food
{
	public function getItemDescription() { return 'A funny and colorful painted easteregg. '; }
	public function getItemWeight() { return 150; }
	public function getItemUseTime(){ return 50; }
	public function getItemPrice() { return 5.95; }
	public function onConsume(SR_Player $player)
	{
		$oldhp = $player->getHP();
		$gain = $player->healHP(rand(1, 5));
		$player->getParty()->message($player, 'giggles. '.Shadowfunc::displayHPGain($oldhp, $gain, $player->getMaxHP()));
	}
}
?>