<?php
final class Seattle_Florist extends SR_Store
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_Florist_Lilly'); }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function getFoundPercentage() { return 40.00; }
	
	/**
	 * Get the items available at the store.
	 * @param SR_Player $player
	 * @return array(array(name, availperc, price, amount))
	 */
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Roses', 100.0, 120.0, 6),
			array('Orchids', 100.0, 260.0, 6),
		);
	}
}
?>
