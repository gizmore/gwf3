<?php
final class Item_WeddingRing extends SR_Ring
{
	public function getItemLevel() { return -1; }
	public function getItemPrice() { return 900; }
	
	public function isItemDropable() { return false; }
	
	public function getItemDescription()
	{
		if (false === ($user = Dog::getUser()))
		{
			$username = '';
		}
		else
		{
			$username = $user->getName();
		}
		
		$partner = 'Your PC';
		switch ($username)
		{
			case 'ynori7': $partner = 'CPUkiller'; break;
			case 'CPUkiller': $partner = 'ynori7'; break;
		}
		return 'Your wedding ring. You are currently married to '.$partner.'.';
	}
	
	public function getItemDropChance() { return 12.00; }
	public function getItemModifiersA(SR_Player $player)
	{
		$back = array();
		switch($player->getRace())
		{
			default: $back['charisma'] = 2.0;
		}
		return $back;
	}
}
?>