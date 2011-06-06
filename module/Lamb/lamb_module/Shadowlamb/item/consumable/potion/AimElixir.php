<?php
final class Item_AimElixir extends SR_Potion
{
	public function getItemLevel() { return 10; }
	public function getItemWeight() { return 350; }
	public function getItemPrice() { return 700; }
	public function getItemDescription() { return 'A magic potion that increases your firearms skill for some time.'; }
	public function onConsume(SR_Player $player)
	{
		$mod = array('firearms' => 1);
		$player->addEffects(new SR_Effect(5400, $mod), new SR_Effect(3600, $mod), new SR_Effect(1800, $mod));
	}
}
?>