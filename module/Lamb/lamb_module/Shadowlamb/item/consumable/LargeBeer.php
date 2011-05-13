<?php
final class Item_LargeBeer extends SR_Consumable
{
	public function getItemLevel() { return 0; }
	public function getItemWeight() { return 600; }
	public function getItemPrice() { return 3.95; }
	public function getItemDescription() { return '0.5 litres of Unz-Beer - 3.37% alc.'; }
	public function onConsume(SR_Player $player)
	{
		$m = array('alcohol'=>0.1);
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*1, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*2, $m));
		$player->addEffects(new SR_Effect(GWF_Time::ONE_HOUR*3, $m));
		$oldhp = $player->getHP();
		$gain = $player->healHP(0.5);
		$player->getParty()->notice(sprintf('%s drank a beer and got alcoholized (+0.3 alc.) %s.', $player->getName(), Shadowfunc::displayHPGain($oldhp, $gain, $player->getMaxHP())));
	}
}
?>