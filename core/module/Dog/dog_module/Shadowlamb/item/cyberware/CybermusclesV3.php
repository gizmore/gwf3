<?php
final class Item_CybermusclesV3 extends SR_Cyberware
{
	public function getItemDescription() { return 'Military fiber muscles increase your strength(5) and quickness(1.5)'; }
	public function getItemPrice() { return 7500; }
	public function getConflicts() { return array('Cybermuscles','CybermusclesV2'); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'quickness' => 1.5,
			'essence' => -2.0,
			'strength' => '*2.2',
		);
// 		return self::mergeModifiers(
// 			self::multiplyStats($player, array('strength' => '1.2')),
// 			array(
// 				'quickness' => 1.5,
// 				'essence' => -2.0,
// 			)
// 		);
	}
}
?>
