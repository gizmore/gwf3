<?php
final class Item_Wine extends SR_Drink
{
	public function getItemLevel() { return 1; }
	public function getItemWeight() { return 825; }
	public function getItemPrice() { return 44.95; }
	public function getLitres() { return 1000; }
	public function getItemDescription() { return 'A cheap bottle of wine. Alc:13%.'; }
//	public function isItemSellable() { return false; }
	public function onConsume(SR_Player $player)
	{
		$m = array('alc'=>0.1);
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*1, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*2, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*3, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*4, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*5, $m));
		$player->getParty()->notice(sprintf('%s drunk a bottle of wine and got alcoholized (+0.5).', $player->getName()));
	}
}
?>