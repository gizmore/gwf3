<?php
final class Item_WiredReflexesV2 extends SR_Cyberware
{
	public function getItemDescription() { return 'Improved Wired Reflexes will boost your quickness(+3). Usually used by Special Forces.'; }
	public function getItemPrice() { return 14000; }
	public function getConflicts() { return array('WiredReflexes','WiredReflexesV3'); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'quickness' => 3.0,
			'essence' => -1.3,
		);
	}
}
?>
