<?php
final class Item_TinfoilGloves extends SR_Gloves
{
	public function getItemLevel() { return 0; }
	public function getItemPrice() { return 2.95; }
	public function getItemWeight() { return 80; }
	public function getItemDescription() { return 'Wrap your fists in tinfoil for better sparkle effects.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'marm' => '0.02',
		);
	}
}
?>
