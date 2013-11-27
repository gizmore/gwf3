<?php
final class Item_ElvenTag extends SR_Amulet
{
	public function getItemLevel() { return 5; }
	public function getItemPrice() { return 400; }
	public function getItemDescription() { return 'A small medallion that emblems the woodelve symbol.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'bows' => 0.1,
		);
	}
}
?>
