<?php
/**
 * Classical ninja potion:
 * 400s ninja+2
 * 200s ninja+1
 * @author gizmore
 */
final class Item_NinjaPotion extends SR_Potion
{
	public function getItemLevel() { return 5; }
	public function getItemWeight() { return 200; }
	public function getItemPrice() { return 300; }
	public function getItemDescription() { return 'Magic potion that increases your ninja skill for a short amount of time.'; }
	public function onConsume(SR_Player $player)
	{
		$mod = array('ninja' => 1);
		$player->addEffects(new SR_Effect(400, $mod), new SR_Effect(200, $mod));
	}
}
?>