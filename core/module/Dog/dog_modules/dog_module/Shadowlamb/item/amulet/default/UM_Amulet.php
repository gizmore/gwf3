<?php
require_once 'LO_Amulet.php';
class Item_UM_Amulet extends Item_LO_Amulet
{
	public function getItemLevel() { return 27; }
	public function getItemDescription() { return 'A piece of the famous Thalion meteor.'; }
	public function getItemDropChance() { return 8.00; }
	public function getItemPrice() { return 2000; }
	public function getItemModifiersA(SR_Player $player)
	{
		$back = array();
		switch($player->getRace())
		{
			default:
				$back['attack'] = 5;
				$back['intelligence'] = 1.5;
				break;
		}
		return SR_Item::mergeModifiers(parent::getItemModifiersA($player), $back);
	}
}
?>