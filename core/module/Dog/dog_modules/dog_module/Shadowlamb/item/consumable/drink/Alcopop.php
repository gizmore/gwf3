<?php
final class Item_Alcopop extends SR_Drink
{
	public function getItemLevel() { return 2; }
	public function getItemWeight() { return 225; }
	public function getLitres() { return 200; }
	public function getItemPrice() { return 9.95; }
	public function getItemDescription() { return 'A small alcopop drink. Alc: 7%. Evil and made by the devil himself.'; }
//	public function isItemSellable() { return false; }
	public function onConsume(SR_Player $player)
	{
		$m = array('alc'=>0.1);
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*1, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*2, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*3, $m));
		$player->getParty()->notice(sprintf('%s drunk an alcopop and got alcoholized (+0.3).', $player->getName()));
	}
}
?>