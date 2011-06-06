<?php
final class Item_QuicknessElixir extends SR_Potion
{
	public function getItemLevel() { return 10; }
	public function getItemWeight() { return 250; }
	public function getItemPrice() { return 550; }
	public function getItemDescription() { return 'A magic potion that increases your quickness for a short amount of time.'; }
	public function onConsume(SR_Player $player)
	{
		$mod = array('quickness' => 1);
		$player->addEffects(new SR_Effect(5400, $mod), new SR_Effect(3600, $mod), new SR_Effect(1800, $mod));
	}
}
?>