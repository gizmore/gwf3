<?php
final class Shadowcmd_drop extends Shadowcmd
{
	private static $CONFIRM = array();
	
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if ( (count($args) < 1) || (count($args) > 2) )
		{
			$bot->reply(Shadowhelp::getHelp($player, 'drop'));
			return false;
		}
		
		if (false === ($item = $player->getInvItem($args[0])))
		{
			$player->msg('1029');
// 			$bot->reply('You don`t have that item.');
			return false;
		}
		
		
		$amt = count($args) === 2 ? (int)$args[1] : 1;
		
		if ($amt < 1)
		{
			$player->msg('1038');
// 			$bot->reply('You can only drop a positive amount of items.');
			return false;
		}
		
		if (!$item->isItemDropable())
		{
			$player->msg('1058');
// 			$bot->reply('You should not drop that item.');
			return false;
		}
		$iname = $item->getItemName();
		$dname = $item->displayFullName($player);
		
		# Confirm
		if (is_numeric($args[0]))
		{
			$pid = (int)$player->getID();
			$msg = implode(' ', $args);
			if ( (!isset(self::$CONFIRM[$pid])) || ($msg !== self::$CONFIRM[$pid]) )
			{
				self::$CONFIRM[$pid] = $msg;
				$player->msg('5110', array($amt, $dname));
// 				$player->message(sprintf('You are about to drop %d %s. Retype to confirm.', $amt, $iname));
				return true;
			}
			else
			{
				unset(self::$CONFIRM[$pid]);
			}
		}
		
		
		$dropped = 0;
		# Drop stackable.
		if ($item->isItemStackable())
		{
//			if ($amt > $item->getAmount())
//			{
//				$bot->reply('You don\'t have that much '.$item->getName().'.');
//				return false;
//			}

			if ($amt > $item->getAmount())
			{
				$amt = $item->getAmount();
			}
			
			if (false === $item->useAmount($player, $amt))
			{
				$bot->reply('Database error 9.');
				return false;
			}
		
			$dropped = $amt;
		}
		

		else
		{
			$items = $player->getInvItems($iname, $amt);
			foreach ($items as $item2)
			{
				if ($player->deleteFromInventory($item2, false))
				{
					$dropped++;
				}
			}
//			$dropped = 0;
//			while ($dropped < $amt)
//			{
//				if (false === ($item2 = $player->getInvItem($args[0])))
//				{
//					break;
//				}
//			}
		}
		
		
		$player->modify();

		return $player->msg('5111', array($dropped, $dname));
// 		$bot->reply(sprintf('You got rid of %d %s.',$dropped, $iname));
// 		return true;
	}
}
?>
