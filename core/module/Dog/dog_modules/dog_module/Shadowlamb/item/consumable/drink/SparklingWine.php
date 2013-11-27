<?php
final class Item_SparklingWine extends SR_Drink
{
	public function getItemLevel() { return 4; }
	public function getItemWeight() { return 825; }
	public function getItemPrice() { return 49.95; }
	public function getItemDescription() { return 'A cheap bottle of sparkling wine. Alc:11%.'; }
//	public function isItemSellable() { return false; }
	public function getLitres() { return 1000; }
	public function onConsume(SR_Player $player)
	{
		$m = array('alc'=>0.1);
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*1, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*2, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*3, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*4, $m));
		$player->getParty()->notice(sprintf('%s drunk a bottle of sparkling wine and got alcoholized (+0.5).', $player->getName()));
	}
}
?>