<?php
final class Item_Headcomputer extends SR_Cyberware
{
	public function getItemDescription() { return 'A headcomputer will allow you to connect to computers.'; }
	public function getItemPrice() { return 3000; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'essence' => -0.2,
		);
	}
}
?>
