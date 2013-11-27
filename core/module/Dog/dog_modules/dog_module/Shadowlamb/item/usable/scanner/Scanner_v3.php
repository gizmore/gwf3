<?php
require_once 'Scanner_v2.php';
class Item_Scanner_v3 extends Item_Scanner_v2
{
	public function getItemDescription() { return 'Will scan a target for stats, attributes and skills.'; }
	public function getItemPrice() { return 600; }
	public function getItemUsetime() { return 25; } 
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
	}
	
	public function onScanLevel3(SR_Player $player, SR_Player $target)
	{
		$message = Shadowfunc::getSkills($target, '5305');
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
