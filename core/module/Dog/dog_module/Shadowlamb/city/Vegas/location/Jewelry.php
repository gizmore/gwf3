<?php
final class Vegas_Jewelry extends SR_Store
{
// 	public function getRealNPCS() { return array('Vegas_Tuna'); }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Vegas_Jeweler'); }
	
	public function getFoundPercentage() { return 20.00; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }

	/**
	 * Get the items available at the store.
	 * @param SR_Player $player
	 * @return array(array(name, availperc, price, amount))
	 */
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Diamond',      100.0, 14999.95, 1),
			array('Emerald',      100.0,  9999.95, 1),
			array('Hematite',     100.0,  5999.95, 1),
			array('Quartz',       100.0,  1495.95, 1),
			array('AmuletOfLove', 100.0,  6499.99, 1),
			array('Moonstone',    100.0,  4999.99, 1),
			array('Amulet',       100.0,  1499.95, 1),
			array('LO_Amulet',    100.0,  4999.95, 1),
			array('Ring',         100.0,   999.95, 1),
			array('LO_Ring',      100.0,  2699.95, 1),
			array('UM_Ring',      100.0,  7999.99, 1),
			array('Earring',      100.0,   999.95, 1),
			array('LO_Earring',   100.0,  2699.95, 1),
		);
	}
}
?>
