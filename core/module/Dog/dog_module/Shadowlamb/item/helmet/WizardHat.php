<?php
final class Item_WizardHat extends SR_Helmet
{
	public function getItemLevel() { return 14; }
	public function getItemPrice() { return 650; }
	public function getItemWeight() { return 550; }
	public function getItemDescription() { return 'A large white wizard\'s hat.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.2,
			'farm' => 0.2,
			'intelligence' => 0.5,
			'wisdom' => 0.4,
			'magic' => 0.4,
		);
	}
}
?>