<?php
final class Item_QuicknessPotion extends SR_Potion
{
	public function getItemLevel() { return 5; }
	public function getItemWeight() { return 200; }
	public function getItemPrice() { return 300; }
	public function getItemDescription() { return 'A magic potion that increases your quickness for a short amount of time.'; }
	public function onConsume(SR_Player $player)
	{
		$mod = array('quickness' => 1);
		$player->addEffects(new SR_Effect(3600, $mod), new SR_Effect(1800, $mod));
	}
}
?>