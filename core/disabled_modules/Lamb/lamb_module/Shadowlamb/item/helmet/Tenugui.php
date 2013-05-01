<?php
final class Item_Tenugui extends SR_Helmet
{
	public function getItemLevel() { return 13; }
	public function getItemPrice() { return 300; }
	public function getItemWeight() { return 1600; }
	public function getItemDescription() { return 'A ninja mask to disguise.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'quickness' => 0.2,
			'marm' => 0.1,
			'farm' => 0.1,
		);
	}
}
?>