<?php
final class Item_Collar extends SR_QuestItem
{
	public function getItemWeight() { return 355; }
	public function getItemDescription() { return 'A collar from Mogrid. You have to bring this to Mr.Johnson in the Seattle Deckers.'; }
	public function isItemDropable() { return false; }
	public function isItemTradeable() { return false; }
}
?>