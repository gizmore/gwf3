<?php
final class Item_DermalPlatesV2 extends SR_Cyberware
{
	public function getItemDescription() { return 'Improved duranium dermal plates, implanted under your skin, improve your armor(2).'; }
	public function getItemPrice() { return 9000; }
	public function getConflicts() { return array('DermalPlates','DermalPlatesV3'); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'marm' => 2.0,
			'farm' => 2.0,
			'essence' => -1.5,
		);
	}
}
?>
