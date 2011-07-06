<?php
final class Item_WaterBottle extends SR_Potion
{
	public function getItemDescription() { return 'A bottle filled with water. Can hold up to 0.4 litres.'; }
	public function getItemWeight() { return 450; }
	public function getItemPrice() { return 28.95; }
	
	public function onConsume(SR_Player $player)
	{
		$player->message('You feel refreshed.');
	}
	
}
?>