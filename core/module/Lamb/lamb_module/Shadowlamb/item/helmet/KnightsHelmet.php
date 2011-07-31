<?php
final class Item_KnightsHelmet extends SR_Helmet
{
	public function getItemLevel() { return 18; }
	public function getItemPrice() { return 850; }
	public function getItemWeight() { return 1750; }
	public function getItemDescription() { return 'A shiny metal helmet used by the medival knights for melee combat.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 2.1,
			'farm' => 0.6,
		);
	}
}
?>