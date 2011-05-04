<?php
final class Item_ON_Ring extends SR_Ring
{
	public function getItemLevel() { return 15; }
	public function getItemPrice() { return 2000; }
	public function getItemDropChance() { return 40.00; }
	public function getItemDescription() { return 'A powerful ring made by evil elves.'; }
	public function getItemModifiersB()
	{
		$mods = parent::getItemModifiersB();
		foreach ($mods as $k => $v)
		{
			$mods[$k] = floor($mods[$k]*2);
		}
		return $mods;
	}
}
?>