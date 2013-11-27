<?php
final class Item_DemonSword extends SR_Sword
{
	public function getAttackTime() { return 40; }
	public function getItemLevel() { return 28; }
	public function getItemWeight() { return 1850; }
	public function getItemPrice() { return 1475; }
	public function getItemRange() { return 3.7; }
	public function getItemDescription() { return 'A long and dark knights sword. It is glowing dark and looks bloody and deadly.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 11.5, 
			'min_dmg' => 4.5,
			'max_dmg' => 17.5,
		);
	}
}
?>
