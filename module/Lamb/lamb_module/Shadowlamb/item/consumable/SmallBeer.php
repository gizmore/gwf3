<?php
final class Item_SmallBeer extends SR_Consumable
{
	public function getItemLevel() { return 0; }
	public function getItemWeight() { return 375; }
	public function getItemPrice() { return 1.95; }
	public function getItemDescription() { return '0.33 litres of Unz-Beer - 0.337% alc.'; }
	public function onConsume(SR_Player $player)
	{
		$m = array('alcohol'=>0.1);
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*1, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*2, $m));
		$oldhp = $player->getHP();
		$gain = $player->healHP(0.3);
		$player->getParty()->notice(sprintf('%s drank a beer and got alcoholized (+0.2) %s.', $player->getName(), Shadowfunc::displayHPGain($oldhp, $gain, $player->getMaxHP())));
	}
}
?>