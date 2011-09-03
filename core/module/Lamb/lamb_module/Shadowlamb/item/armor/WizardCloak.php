<?php
final class Item_WizardCloak extends SR_Armor
{
	public function getItemLevel() { return 8; }
	public function getItemPrice() { return 700; }
	public function getItemWeight() { return 455; }
	public function getItemDescription() { return 'a small black robe for wizards. Looks best with glasses and a book.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.4,
			'farm' => 0.4,
			'wisdom' => 0.6,
			'intelligence' => 0.6,
			'quickness' => 0.5,
		);
	}
}
?>