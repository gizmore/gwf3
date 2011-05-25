<?php
require_once 'Scanner_v3.php';
class Item_Scanner_v4 extends Item_Scanner_v3
{
	public function getItemDescription() { return 'Will scan a target for stats, attributes, skills and cyberware.'; }
	public function getItemPrice() { return 800; }
	public function getItemUsetime() { return 55; } 
	public function getItemWeight() { return 450; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		if (false === ($target = $this->getScannerTarget($player, $args))) {
			$player->message('Invalid target for scanner.');
			return false;
		}
		$this->onScanLevel1($player, $target);
		$this->onScanLevel2($player, $target);
		$this->onScanLevel3($player, $target);
		$this->onScanLevel4($player, $target);
	}
	
	public function onScanLevel4(SR_Player $player, SR_Player $target)
	{
		$message = 'Cyberware: '.Shadowfunc::getCyberware($target);
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
