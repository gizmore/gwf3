<?php
final class Shadowcmd_hijack extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		if (false === ($location = $p->getLocationClass('outside')))
		{
			return $player->reply('This command only works when you are outside a location.');
		}
		
		$bot = Shadowrap::instance($player);
		
		$loc = $location->getName();
		
		if (count($args) > 1)
		{
			return $bot->reply(Shadowhelp::getHelp($player, 'hijack'));
		}

		$victims = array();
		foreach (Shadowrun4::getParties() as $pa)
		{
			$pa instanceof SR_Party;
			$loc2 = $pa->getLocation('inside');
			if ($loc === $loc2)
			{
				foreach ($pa->getMembers() as $pl)
				{
					$pl instanceof SR_Player;
					if ($pl->hasEquipment('mount'))
					{
						$victims[] = $pl;
					}
				}
			}
		}
		
		if (count($victims) === 0)
		{
			return $player->message('You see no mounts from other players to rob.');
		}
		
		if (count($args) === 0)
		{
			$out = '';
			foreach ($victims as $i => $victim)
			{
				$victim instanceof SR_Player;
				$mount = $victim->getMount();
				$out .= sprintf(", \x02%s\x02-%s(%s)", ($i+1), $victim->getName(), $mount->getName());
			}
			return $bot->reply(substr($out, 2));
		}
		
		if (false === ($target = self::getHijackTarget($victims, $args[1])))
		{
			return false;
		}
		
	}
	
	private static function getHijackTarget($victims, $arg)
	{
		if (is_numeric($arg))
		{
			$arg = (int)$arg;
			if ( ($arg > 0) AND ($arg <= count($victims)) )
			{
				return $victims[$arg-1];
			}
		}
		
		foreach ($victims as $victim)
		{
			$victim instanceof SR_Player;
			if ( ($victim->getShortName() === $arg) || ($victim->getName() === $arg) )
			{
				return $victim;
			}
		}
		
		return false;
	}
}
?>
