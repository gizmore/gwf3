<?php
final class Item_Fish extends SR_Consumable
{
	public function getItemDescription() { return 'A frozen trout.'; }
	public function getItemWeight() { return 333; }
	public function getItemUseTime(){ return 45; }
	public function getItemPrice() { return 4.95; }
	public function onConsume(SR_Player $player)
	{
		$oldhp = $player->getHP();
		$gain = $player->healHP(2);
		$player->getParty()->message($player, 'ate a trout and healed two cent. '.Shadowfunc::displayHPGain($oldhp, $gain, $player->getMaxHP()).' ... Lamer!');
	}
}
?>