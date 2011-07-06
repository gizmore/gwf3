<?php
final class Item_CybermusclesV2 extends SR_Cyberware
{
	public function getItemDescription() { return 'Improved muscle fibers increase your strength(3) and quickness(1)'; }
	public function getItemPrice() { return 7500; }
	public function getConflicts() { return array('Cybermuscles','CybermusclesV3'); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'strength' => 3,
			'quickness' => 1,
			'essence' => -1.5,
		);
	}
}
?>
