<?php
require_once 'Scanner_v5.php';
class Item_Scanner_v6 extends Item_Scanner_v5
{
	public function getItemDescription() { return 'Will scan a target for stats, attributes, skills, cyberware and spells. Additionaly it allows #spy to locate a player.'; }
	public function getItemPrice() { return 3000; }
	public function getItemUsetime() { return 12; } 
	public function getItemWeight() { return 350; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		if (false === ($target = $this->getScannerTarget($player, $args)))
		{
			$player->message('Invalid target for scanner.');
			return false;
		}
		$this->onScanLevel1($player, $target);
		$this->onScanLevel2($player, $target);
		$this->onScanLevel3($player, $target);
		$this->onScanLevel4($player, $target);
		$this->onScanLevel5($player, $target);
	}
}
?>
