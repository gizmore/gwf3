<?php
final class Item_Sporn extends SR_Cyberware
{
	public function getItemDescription() { return 'A sporn is an implanted weapon under your skin and improves melee by 1.5.'; }
	public function getItemPrice() { return 1800; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'melee' => 1.5,
			'essence' => -0.5,
		);
	}
}
?>
