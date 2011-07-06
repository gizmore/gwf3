<?php
final class Item_NinjaElixir extends SR_Potion
{
	public function getItemLevel() { return 10; }
	public function getItemWeight() { return 250; }
	public function getItemPrice() { return 600; }
	public function getItemDescription() { return 'Magic potion that increases your ninja skill for some time.'; }
	public function onConsume(SR_Player $player)
	{
		$mod = array('ninja' => 1);
		$player->addEffects(new SR_Effect(5400, $mod), new SR_Effect(3600, $mod), new SR_Effect(1800, $mod));
	}
}
?>