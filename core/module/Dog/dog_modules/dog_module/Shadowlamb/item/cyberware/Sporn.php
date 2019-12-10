<?php
final class Item_Sporn extends SR_Cyberware
{
	public function getItemDescription() { return 'A sporn is an implanted, sub-dermal weapon and improves melee combat by 1.5.'; }
	public function getItemPrice() { return 1850; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'melee' => 1.5,
			'ninja' => 1.5,
			'essence' => -0.5,
		);
	}
}
