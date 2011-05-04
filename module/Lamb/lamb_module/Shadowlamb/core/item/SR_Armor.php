<?php
abstract class SR_Armor extends SR_Equipment
{
	public function getItemType() { return 'armor'; }
//	
//	public function getItemTypeDescr(SR_Player $player)
//	{
//		$mods = $this->getItemModifiersA($player);
//		return sprintf('defense/marm/farm:(%s/%s/%s)', $mods['defense'], $mods['marm'], $mods['farm']);
//	}
	
}