<?php
final class Item_SmartGoggles extends SR_Cyberware
{
	public function getItemDescription() { return 'Connects your eyes with your gun. This improves the chance to hit (firearms+2).'; }
	public function getItemPrice() { return 2500; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'firearms' => 2.0,
			'essence' => -0.4,
		);
	}
}

?>
