<?php
final class Item_BoxingGloves extends SR_Gloves
{
	public function getItemLevel() { return 15; }
	public function getItemPrice() { return 99; }
	public function getItemWeight() { return 600; }
	public function getItemDescription() { return 'Thick red boxing gloves in good shape. Not very useful on the streets.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => '0.5',
			'maxdmg' => '-1.5',
		);
	}
}
?>
