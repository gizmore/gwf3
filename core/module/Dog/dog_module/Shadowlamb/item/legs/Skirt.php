<?php
final class Item_Skirt extends SR_Legs
{
	public function getItemLevel() { return 1; }
	public function getItemPrice() { return 60; }
	public function getItemWeight() { return 350; }
	public function getItemDescription() { return 'A beautiful red skirt. You feel flyffy in there.'; }
	public function getItemRequirements() { return array('gender'=>'female'); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.1,
			'farm' => 0.1,
			'charisma' => 0.5,
		);
	}
}
?>