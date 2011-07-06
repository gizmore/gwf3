<?php
final class Item_Auris extends SR_QuestItem
{
	public function getItemWeight() { return 0; }
	public function getItemDuration() { return Seattle::TIME_TO_DELAWARE + 60; }
	public function getItemDescription() { return 'Magic matter with a zero weight. The more magic power you invest in this irregular matter, the longer it exists. Some physicians believe the Auris is the cause for fluctuations after the BigBang.'; }
	public function isItemDropable() { return true; }
	public function isItemTradeable() { return false; }
}
?>