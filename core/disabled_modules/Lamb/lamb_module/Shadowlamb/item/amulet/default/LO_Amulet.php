<?php
class Item_LO_Amulet extends SR_Amulet
{
	public function getItemLevel() { return 17; }
	public function getItemDescription() { return 'This amulet is a piece of the magic ThalionLionhearth.'; }
	public function getItemDropChance() { return 13.00; }
	public function getItemPrice() { return 1000; }
	public function getItemModifiersA(SR_Player $player)
	{
		$back = array();
		switch($player->getRace())
		{
			default:
				$back['max_hp'] = 2.5;
				$back['max_mp'] = 5.0;
				break;
		}
		return $back;
	}
}
?>