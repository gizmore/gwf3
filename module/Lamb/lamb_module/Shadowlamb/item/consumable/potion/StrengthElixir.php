<?php
final class Item_StrengthElixir extends SR_Potion
{
	public function getItemLevel() { return 10; }
	public function getItemWeight() { return 250; }
	public function getItemPrice() { return 450; }
	public function getItemDescription() { return 'Magic potion that increases your strength for a short amount of time.'; }
	public function onConsume(SR_Player $player)
	{
		$mod = array('strength' => 1);
		$player->addEffects(new SR_Effect(600, $mod), new SR_Effect(400, $mod), new SR_Effect(200, $mod));
	}
}
?>