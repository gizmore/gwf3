<?php
class Item_Scanner_v1 extends SR_Usable
{
	public function getItemDescription() { return 'Will scan a target for stats.'; }
	public function getItemPrice() { return 600; }
	public function getItemUsetime() { return 55; } 
	public function getItemWeight() { return 450; }
	public function isItemFriendly() { return true; }
	public function isItemOffensive() { return true; }
	
	public function getScannerTarget(SR_Player $player, array $args)
	{
		if (count($args) !== 1) {
			return false;
		}
		$p = $player->getParty();
		if ($p->isFighting())
		{
			return $this->getOffensiveTarget($player, $args[0]);
		}
		else
		{
			return $this->getFriendlyTarget($player, $args[0]);
		}
		return $target;
	}
	
	public function onItemUse(SR_Player $player, array $args)
	{
		if (false === ($target = $this->getScannerTarget($player, $args))) {
			$player->message('Invalid target for scanner.');
			return false;
		}
		$this->onScanLevel1($player, $target);
	}
	
	public function onScanLevel1(SR_Player $player, SR_Player $target)
	{
		$message = $target->getName().': '.Shadowfunc::getStatus($target);
		$message2 = Shadowfunc::getEquipment($target);
		if ($player->isFighting())
		{
			$player->message($message);
			$player->message($message2);
		}
		else
		{
			Shadowrap::instance($player)->reply($message);
			Shadowrap::instance($player)->reply($message2);
		}
	}
}
?>
