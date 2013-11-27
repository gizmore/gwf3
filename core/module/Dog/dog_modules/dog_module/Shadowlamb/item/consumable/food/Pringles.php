<?php
final class Item_Pringles extends SR_Food
{
	public function getItemLevel() { return -1; }
	public function getItemDescription() { return 'A roll of pringles. Bacon flavoured.'; }
	public function getItemUsetime() { return 20; }
	public function getItemDefaultAmount() { return 6; }
	public function getItemWeight() { return 5; }
	public function getWater() { return 1; }
	public function getCalories() { return 5; }
	public function onConsume(SR_Player $player)
	{
		$p = $player->getParty();
		
		$oldhp = $player->getHP();
		$maxhp = $player->getMaxHP();
		$gain = $player->healHP(0.10);
		$newhp = $player->getHP();
		$gainmsg = Shadowfunc::displayHPGain($oldhp, $gain, $maxhp);
		
		$last = $this->getAmount() === 0 ? 'the last' : 'a';
		if ($p->isFighting())
		{
			$busy = $this->getItemUsetime();
			$player->busy($busy);
			$busytext = sprintf(' %s busy.', GWF_Time::humanDuration($busy));
			$p->message($player, sprintf(' eats %s potatoe chip from his roll of Pringles: %s.%s', $last, $gainmsg, $busytext));
			$p->getEnemyParty()->message($player, sprintf(' eats %s chip from his roll of Pringles.', $last));
		}
		else
		{
			$player->message(sprintf('You eat %s chip from your Pringles: %s', $last, $gainmsg));
		}
	}
}
?>