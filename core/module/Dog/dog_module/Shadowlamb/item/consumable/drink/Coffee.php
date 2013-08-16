<?php
final class Item_Coffee extends SR_Potion
{
	public function getItemLevel() { return -1; }
	public function getItemWeight() { return 250; }
	public function getLitres() { return 200; }
	public function getItemPrice() { return 3.95; }
	public function getItemDescription() { return 'A coffee to go.'; }
	public function isItemSellable() { return false; }
	public function onConsume(SR_Player $player)
	{
		$m = array('caf'=>0.1);
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*1, $m));
	}
}
?>