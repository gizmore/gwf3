<?php
final class Item_KevlarShield extends SR_Shield
{
	public function getItemLevel() { return 18; }
	public function getItemPrice() { return 1500; }
	public function getItemWeight() { return 2250; }
	public function getItemDescription() { return 'A large protective kevlar shield, used by special forces.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.3,
			'marm' => 0.6,
			'farm' => 0.7,
		);
	}
	
}
?>