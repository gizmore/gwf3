<?php
final class Shadowcmd_give extends Shadowcmd
{
	public static function isCombatCommand() { return true; }
	
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ( (count($args) < 2) || (count($args) > 3) )
		{
			$player->message(Shadowhelp::getHelp($player, 'give'));
			return false;
		}
		
		if (false === ($target = Shadowfunc::getFriendlyTarget($player, $args[0])))
		{
			$player->msg('1028', array($args[0]));
// 			$player->message(sprintf('%s is not here or the name is ambigous.', $args[0]));
			return false;
		}
		
		if ($target->getID() === $player->getID())
		{
			$player->msg('1061');
// 			$player->message('Funny. You give something to yourself. Problem?');
			return false;
		}			
		
		return self::giveItem($player, $target, $args[1], (isset($args[2])?intval($args[2],10):1) );
	}
	
	public static function giveItem(SR_Player $player, SR_Player $target, $id, $amt=1)
	{
		if ($amt < 1)
		{
			$player->msg('1038');
// 			$player->message('Please give a positive amount of items.');
			return false;
		}
		
		if (false === ($item = $player->getInvItem($id)))
		{
			$player->msg('1029');
// 			$player->message('You don`t have that item.');
			return false;
		}
		
// 		if (false === $item->isItemTradeable())
// 		{
// 			$player->message('You are not allowed to trade this item.');
// 			return false;
// 		}

		if ($item->isItemStackable())
		{
			if ($amt > $item->getAmount())
			{
				$player->msg('1040', array($item->getItemName()));
// 				$player->message(sprintf('You only have %d %s.', $item->getAmount(), $item->getName()));
				return false;
			}
			$giveItem = SR_Item::createByName($item->getItemName(), $amt, true);
			$item->useAmount($player, $amt);
		}
		else
		{
			if ($amt !== 1)
			{
				$player->message('Currently you can only give one equipment at a time.');
				return false;
			}
			$player->removeFromInventory($item);
			$giveItem = $item;
		}
		
		$busymsg = $player->isFighting() ? Shadowfunc::displayBusy($player->busy(SR_Player::GIVE_TIME)) : '';
		
		self::rply($player, '5115', array($amt, $giveItem->displayFullName($player), $target->getName(), $busymsg));
		
// 		$player->message(sprintf('You gave %d %s to %s.%s', $amt, $giveItem->getName(), $target->getName(), $busymsg));

		$items = array($giveItem);
		
		$target->giveItems($items, $player->getName());
		
// 		if ($target instanceof SR_TalkingNPC)
// 		{
// 			$target->onNPCGive($player, $items);
// 		}
		
		return true;
	}
}
?>
