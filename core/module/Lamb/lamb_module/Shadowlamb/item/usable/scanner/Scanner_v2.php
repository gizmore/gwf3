<?php
require_once 'Scanner_v1.php';
class Item_Scanner_v2 extends Item_Scanner_v1
{
	public function getItemDescription() { return 'Will scan a target for stats and attributes.'; }
	public function getItemPrice() { return 600; }
	public function getItemUsetime() { return 45; } 
	public function getItemWeight() { return 450; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		if (false === ($target = $this->getScannerTarget($player, $args))) {
			$player->message('Invalid target for scanner.');
			return false;
		}
		$this->onScanLevel1($player, $target);
		$this->onScanLevel2($player, $target);
	}
	
	public function onScanLevel2(SR_Player $player, SR_Player $target)
	{
		$message = 'Attributes: '.Shadowfunc::getAttributes($target);
		if ($player->isFighting())
		{
			$player->message($message);
		}
		else
		{
			Shadowrap::instance($player)->reply($message);
		}
	}
	
}
?>
