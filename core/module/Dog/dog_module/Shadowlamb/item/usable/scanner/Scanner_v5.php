<?php
require_once 'Scanner_v4.php';
class Item_Scanner_v5 extends Item_Scanner_v4
{
	public function getItemDescription() { return 'Will scan a target for stats, attributes, skills, cyberware and spells.'; }
	public function getItemPrice() { return 2000; }
	public function getItemUsetime() { return 15; } 
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
		$this->onScanLevel5($player, $target);
	}
	
	public function onScanLevel5(SR_Player $player, SR_Player $target)
	{
		$message = Shadowfunc::getSpells($target, '5307');
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
