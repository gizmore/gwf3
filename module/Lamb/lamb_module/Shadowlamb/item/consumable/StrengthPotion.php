<?php
final class Item_StrengthPotion extends SR_Consumable
{
	public function getItemLevel() { return 5; }
	public function getItemWeight() { return 200; }
	public function getItemPrice() { return 200; }
	public function getItemDescription() { return 'Magic potion that increases your strength for a short amount of time.'; }
	public function onConsume(SR_Player $player)
	{
		$mod = array('strength' => 1);
		$player->addEffects(new SR_Effect(400, $mod), new SR_Effect(200, $mod));
	}
}
?>