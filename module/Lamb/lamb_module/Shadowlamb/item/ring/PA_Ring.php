<?php
final class Item_PA_Ring extends SR_Ring
{
	public function getItemLevel() { return 25; }
	public function getItemPrice() { return 8000; }
	public function getItemDropChance() { return 20.00; }
	public function getItemDescription() { return 'A magical ring. The origin is unknown and a mystery'; }
	
	public function getItemModifiersA(SR_Player $player)
	{
		$back = array();
		switch($player->getRace())
		{
			default: $back['attack'] = 1.5;
			default: $back['wisdom'] = 1.5;
			default: $back['intelligence'] = 1.5;
		}
		return $back;
	}

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