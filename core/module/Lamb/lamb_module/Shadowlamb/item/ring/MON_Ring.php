<?php
final class Item_MON_Ring extends SR_Ring
{
	public function getItemLevel() { return 62; }
	public function getItemPrice() { return 16000; }
	public function getItemDropChance() { return 1; }
	public function getItemDescription() { return 'Ash nazg durbatulûk, ash nazg gimbatul, ash nazg thrakatulûk agh burzum-ishi krimpatul.'; }
	public function getItemModifiersB()
	{
		$mods = parent::getItemModifiersB();
		foreach ($mods as $k => $v)
		{
			$mods[$k] = ceil($mods[$k]*2);
		}
		return $mods;
	}
}
?>