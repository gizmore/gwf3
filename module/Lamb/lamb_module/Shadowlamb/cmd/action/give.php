<?php
final class Shadowcmd_give extends Shadowcmd
{
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
			$player->message(sprintf('%s is not here or the name is ambigous.', $args[0]));
			return false;
		}
		
		if ($target->getID() === $player->getID())
		{
			$player->message('Funny. You give something to yourself. Problem?');
			return false;
		}			
		
		return self::giveItem($player, $target, $args[1], (isset($args[3])?intval($args[3],10):1) );
	}
	
	public static function giveItem(SR_Player $player, SR_Player $target, $id, $amt=1)
	{
		if (false === ($item = $player->getInvItem($id)))
		{
			$player->message('You don`t have that item.');
			return false;
		}

		if ($item->isItemStackable())
		{
			if ($amt > $item->getAmount())
			{
				$player->message(sprintf('You only have %d %s.', $item->getAmount(), $item->getName()));
				return false;
			}
			$giveItem = SR_Item::createByName($item->getName(), $amt, true);
			$item->useAmount($player, $amt);
		}
		else
		{
			$player->removeFromInventory($item);
			$giveItem = $item;
		}
		
		$busymsg = $player->isFighting() ? Shadowfunc::displayBusy($player->busy(SR_Player::GIVE_TIME)) : '';
		$player->message(sprintf('You gave %d %s to %s.%s', $amt, $giveItem->getName(), $target->getName(), $busymsg));

		$target->giveItems(array($giveItem), $player->getName());
		
		return true;
	}
}
?>
