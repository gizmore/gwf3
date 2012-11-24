<?php
final class Item_Cap extends SR_Helmet
{
	public function getItemLevel() { return 0; }
	public function getItemPrice() { return 50; }
	public function getItemWeight() { return 350; }
	public function getItemDescription() { return 'A cap with your favorite sports team.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.2,
			'farm' => 0.2,
		);
	}
	
}
?>