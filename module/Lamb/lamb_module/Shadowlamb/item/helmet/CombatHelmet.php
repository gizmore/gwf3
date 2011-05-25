<?php
final class Item_CombatHelmet extends SR_Helmet
{
	public function getItemLevel() { return 13; }
	public function getItemPrice() { return 8000; }
	public function getItemWeight() { return 1600; }
	public function getItemDescription() { return 'This helmet would look dangerous with a BodyArmor.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => -0.3,
			'marm' => 2.4,
			'farm' => 1.8,
		);
	}
	
}
?>