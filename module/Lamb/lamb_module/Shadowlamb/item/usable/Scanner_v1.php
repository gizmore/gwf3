<?php
class Item_Scanner_v1 extends SR_Usable
{
	public function getItemDescription() { return 'Will scan a target for stats.'; }
	public function getItemPrice() { return 600; }
	public function getItemUsetime() { return 55; } 
	public function getItemWeight() { return 450; }
	public function isItemFriendly() { return true; }
	public function isItemOffensive() { return true; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		if (count($args) !== 1) {
			$player->message('Invalid target for scanner');
			return false;
		}
		
		$p = $player->getParty();
		if ($p->isFighting())
		{
			$target = $this->getOffensiveTarget($player, $args[0]);
		}
		else
		{
			$target = $this->getFriendlyTarget($player, $args[0]);
		}
		
		if ($target === false) {
			$player->message('Invalid target for scanner');
			return false;
		}
	}
}
?>
