<?php
class Item_Cybermuscles extends SR_Cyberware
{
	public function getItemDescription() { return 'Cybermuscles increase your strength(1.5) and quickness(0.5).'; }
	public function getItemPrice() { return 4500; }
	public function getConflicts() { return array('CybermusclesV2','CybermusclesV3'); }
	public function getItemModifiersA(SR_Player $player)
	{
		return self::mergeModifiers(
			self::multiplyStats($player, array('strength' => '0.5')),
			array(
				'quickness' => 1.0,
				'essence' => -1.0,
			)
		);
	}
}
?>