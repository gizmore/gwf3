<?php
final class Item_CombatHelmet extends SR_Helmet
{
	public function getItemLevel() { return 9; }
	public function getItemPrice() { return 8000; }
	public function getItemWeight() { return 1600; }
	public function getItemDescription() { return 'This helmet would look dangerous with a body-armor.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => -0.5,
			'marm' => 2.5,
			'farm' => 1.8,
		);
	}
	
}
?>