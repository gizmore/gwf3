<?php
final class Forest_Witchhouse extends SR_Alchemist
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Forest_Witch'); }
	public function getFoundPercentage() { return 20; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function allowShopSell(SR_Player $player) { return false; }
	
	/**
	 * Get the items available at the store.
	 * @param SR_Player $player
	 * @return array(array(name, availperc, price, amount))
	 */
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Ether', 100.0, 3500, 1),
			array('MagicOil', 100.0, 5000, 1),
		);
	}
	
	/**
	 * Get available recipes.
	 * @param SR_Player $player
	 * @return array(array(name, price, product, array(incredients))
	 */
	public function getRecipes(SR_Player $player)
	{
		return array(
			array('Ether', 100, '1xEther', array('3xBolete', '2xBlackOrchid')),
			array('MagicOil', 100, '1xMagicOil', array('4xBone', '1xWhiteOrchid')),
		);
	}
}
?>
