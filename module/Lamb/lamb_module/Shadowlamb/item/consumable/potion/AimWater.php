<?php
final class Item_AimWater extends SR_Consumable
{
	public function getItemLevel() { return 5; }
	public function getItemWeight() { return 250; }
	public function getItemPrice() { return 400; }
	public function getItemDescription() { return 'A magic potion that increases your firearms skill for a short amount of time.'; }
	public function onConsume(SR_Player $player)
	{
		$mod = array('firearms' => 1);
		$player->addEffects(new SR_Effect(400, $mod), new SR_Effect(200, $mod));
	}
}
?>