<?php
final class Item_CybermusclesV2 extends SR_Cyberware
{
	public function getItemDescription() { return 'Improved muscle fibers increase your strength(3) and quickness(1)'; }
	public function getItemPrice() { return 7500; }
	public function getConflicts() { return array('Cybermuscles','CybermusclesV3'); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'quickness' => 1.5,
			'essence' => -1.5,
			'strength' => '*1.8',
		);
// 		return self::mergeModifiers(
// 			self::multiplyStats($player, array('strength' => '0.8')),
// 			array(
// 				'quickness' => 1.5,
// 				'essence' => -1.5,
// 			)
// 		);
	}
}
?>
