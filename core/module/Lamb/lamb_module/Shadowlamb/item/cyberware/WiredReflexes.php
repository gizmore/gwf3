<?php
final class Item_WiredReflexes extends SR_Cyberware
{
	public function getItemDescription() { return 'Wired reflexes will boost your quickness(+2).'; }
	public function getItemPrice() { return 10000; }
	public function getConflicts() { return array('WiredReflexesV2','WiredReflexesV3'); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'quickness' => 2.0,
			'essence' => -1.0,
		);
	}
}

?>
