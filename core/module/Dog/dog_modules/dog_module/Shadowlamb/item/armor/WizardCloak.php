<?php
final class Item_WizardCloak extends SR_Armor
{
	public function getItemLevel() { return 10; }
	public function getItemPrice() { return 700; }
	public function getItemWeight() { return 455; }
	public function getItemDescription() { return 'a small black robe for wizards. Looks best with glasses and a book.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.5,
			'marm' => 0.6,
			'farm' => 0.5,
			'wisdom' => 0.9,
			'intelligence' => 0.9,
		);
	}
}
?>