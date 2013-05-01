<?php
final class Item_Cake extends SR_Food
{
	public function getItemDescription() { return 'A delicious cake baken by Unhandled\'s mom.'; }
	public function getItemWeight() { return 500; }
	public function getItemUseTime(){ return 90; }
	public function onConsume(SR_Player $player)
	{
		$oldhp = $player->getHP();
		$gain = $player->healHP(25);
		$player->getParty()->message($player, 'ate a cake. '.Shadowfunc::displayHPGain($oldhp, $gain, $player->getMaxHP()));
	}
}
?>
