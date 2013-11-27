<?php
final class Item_DermalPlatesV3 extends SR_Cyberware
{
	public function getItemDescription() { return 'Military duranium composite plates, implanted under your skin, improve your armor(3).'; }
	public function getItemPrice() { return 16000; }
	public function getConflicts() { return array('DermalPlates','DermalPlatesV2'); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'marm' => 3.5,
			'farm' => 3.5,
			'essence' => -2.0,
		);
	}
}
?>
