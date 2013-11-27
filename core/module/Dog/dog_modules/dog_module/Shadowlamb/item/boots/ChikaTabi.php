<?php
final class Item_ChikaTabi extends SR_Boots
{
	public function getItemLevel() { return 13; }
	public function getItemPrice() { return 450; }
	public function getItemWeight() { return 450; }
	public function getItemDescription() { return 'Quality ninja boots. They have are of thin nylon material and have a separate big toe.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.5,
			'marm' => 0.4,
			'farm' => 0.4,
			'quickness' => 0.8,
		);
	}
}
?>