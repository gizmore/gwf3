<?php
final class Item_LokiSmoozy extends SR_Drink
{
	public function getItemLevel() { return 8; }
	public function getItemWeight() { return 225; }
	public function getItemPrice() { return 9.95; }
	public function getItemDescription() { return 'A bad approach of marketing an alcopop. Alc: 7.77%.'; }
//	public function isItemSellable() { return false; }
	public function onConsume(SR_Player $player)
	{
		$m = array('alc'=>0.1);
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*1, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*2, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*3, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*4, $m));
		$player->getParty()->notice(sprintf('%s drunk an alcopop and got alcoholized (+0.4).', $player->getName()));
	}
}
?>