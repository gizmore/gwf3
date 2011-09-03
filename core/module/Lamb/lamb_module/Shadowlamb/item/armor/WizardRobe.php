<?php
final class Item_WizardRobe extends SR_Armor
{
	public function getItemLevel() { return 10; }
	public function getItemPrice() { return 900; }
	public function getItemWeight() { return 790; }
	public function getItemDescription() { return 'A white robe for wizards. Looks best with a long beard.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.6,
			'farm' => 0.6,
			'wisdom' => 0.7,
			'intelligence' => 0.7,
			'quickness' => 0.3,
		);
	}
}
?>