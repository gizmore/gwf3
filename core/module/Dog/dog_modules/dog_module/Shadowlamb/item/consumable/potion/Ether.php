<?php
final class Item_Ether extends SR_Potion
{
	public function getItemLevel() { return 16; }
	public function getItemWeight() { return 250; }
	public function getItemPrice() { return 300; }
	public function getItemDropChance() { return 13.37; }
	public function getItemDescription() { return 'A magic potion that stimulates your neocortex. The result is a refreshing MP.'; }
	public function onConsume(SR_Player $player)
	{
		$es = $player->get('essence');
		$min = 3 + $es * 2; # 15
		$max = $min * 2; # 30
		$gain = rand($min, $max);
		$gained = $player->healMP($gain);
		$player->message(sprintf('You gained +%s MP!', $gained));
	}
}
?>