<?php
final class Item_WoolGloves extends SR_Gloves
{
	public function getItemLevel() { return 1; }
	public function getItemPrice() { return 39; }
	public function getItemWeight() { return 150; }
	public function getItemDescription() { return 'Thick wool gloves as your grandma would knit them. Keeps you warm and comfy'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'marm' => '0.05',
		);
	}
}
?>
