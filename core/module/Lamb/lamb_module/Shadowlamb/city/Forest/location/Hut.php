<?php
final class Forest_Hut extends SR_Store
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Forest_Ranger'); }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }

	public function getFoundPercentage() { return 30; }
	
	/**
	 * Get the items available at the store.
	 * @param SR_Player $player
	 * @return array(array(name, availperc, price, amount))
	 */
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Ammo_Arrow', 100.0,  100,  25),
			array('Ammo_Arrow', 100.0,  300, 100),
			array('ElvenBow',   100.0, 1500),
			array('DarkBow',    100.0, 4500),
			array('ReignBow',   100.0, 9500),
		);
	}
}
?>
