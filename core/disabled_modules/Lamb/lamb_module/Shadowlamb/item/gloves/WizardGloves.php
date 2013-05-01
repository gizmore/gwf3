<?php
final class Item_WizardGloves extends SR_Gloves
{
	public function getItemLevel() { return 14; }
	public function getItemPrice() { return 129; }
	public function getItemWeight() { return 240; }
	public function getItemDescription() { return 'Long-sleeved black gloves made of black silk. They seem to have a magical sphere surrounding them.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => '0.1',
			'intelligence' => '1.0',
			'wisdom' => '1.0',
			'orcas' => '0.5',
			'magic' => '0.5',
		);
	}
}
?>
