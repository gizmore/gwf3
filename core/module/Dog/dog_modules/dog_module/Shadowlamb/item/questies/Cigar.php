<?php
final class Item_Cigar extends SR_Usable
{
	public function getItemWeight() { return 50; }
	public function getItemDescription() { return 'A big handrolled cigar from the cubanic amerindian people.'; }
	public function getItemPrice() { return 169; }
	public function isItemLootable() { return false; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		if (!$player->getInvItemByName('Lighter', false))
		{
			$player->message('You don\'t have a lighter.');
			return false;
		}
		
		return true;
	}
}
?>
