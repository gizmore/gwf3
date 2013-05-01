<?php
final class Item_ON_Ring extends SR_Ring
{
	public function getItemLevel() { return 32; }
	public function getItemPrice() { return 2500; }
	public function getItemDropChance() { return 8; }
	public function getItemDescription() { return 'A powerful ring made by evil elves.'; }
	public function getItemModifiersB()
	{
		$mods = parent::getItemModifiersB();
		foreach ($mods as $k => $v)
		{
			$mods[$k] = floor($mods[$k]*1.5);
		}
		return $mods;
	}
}
?>