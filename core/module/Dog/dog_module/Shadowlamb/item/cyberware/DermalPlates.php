<?php
final class Item_DermalPlates extends SR_Cyberware
{
	public function getItemDescription() { return 'These plates of kevlar, implanted under your skin, improve your armor(1)'; }
	public function getItemPrice() { return 4500; }
	public function getConflicts() { return array('DermalPlatesV2','DermalPlatesV3'); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'marm' => 1.0,
			'farm' => 1.0,
			'essence' => -0.8,
		);
	}
}
?>