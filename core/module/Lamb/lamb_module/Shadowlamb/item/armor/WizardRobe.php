<?php
final class Item_WizardRobe extends SR_Armor
{
	public function getItemLevel() { return 12; }
	public function getItemPrice() { return 900; }
	public function getItemWeight() { return 790; }
	public function getItemDescription() { return 'A white robe for wizards. Looks best with a long beard.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.4,
			'marm' => 0.7,
			'farm' => 0.6,
			'wisdom' => 0.9,
			'intelligence' => 1.1,
		);
	}
}
?>