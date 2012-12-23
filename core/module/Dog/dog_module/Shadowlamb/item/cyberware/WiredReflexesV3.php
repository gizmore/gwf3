<?php
final class Item_WiredReflexesV3 extends SR_Cyberware
{
	public function getItemDescription() { return 'Military Wired Reflexes will boost your quickness(+4).'; }
	public function getItemPrice() { return 155000; }
	public function getConflicts() { return array('WiredReflexes','WiredReflexesV2'); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
// 			'quickness' => 2.0,
			'essence' => -1.6,
			'quickness' => '*2.2',
		);
// 		return self::mergeModifiers(
// 			self::multiplyStats($player, array('quickness' => '1.2')),
// 			array(
// 				'quickness' => 2.0,
// 				'essence' => -1.6,
// 			)
// 		);
	}
}
?>
