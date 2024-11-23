<?php
final class Shadowcmd_hijack extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		if (false === ($location = $p->getLocationClass('outside')))
		{
			return $player->msg('1031');
// 			return $player->message('This command only works when you are outside a location.');
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
			if (false === ($city = $pa->getCityClass()))
			{
				continue; # not even city
			}

			# Hax!
			if (
				($city->isDungeon()) && (($city->getCityLocation() === $loc)) ||
				($pa->getLocation('inside') === $loc)
			)
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
			$player->msg('5128');
			return false;
// 			return $player->message('You see no mounts from other players to rob.');
		}
		
		$format = $player->lang('fmt_sumlist');
		if (count($args) === 0)
		{
			$out = '';
			foreach ($victims as $i => $victim)
			{
				$victim instanceof SR_Player;
				$mount = $victim->getMount();
				$out .= sprintf($format, ($i+1), $victim->getName(), $mount->getName());
// 				$out .= sprintf(", \x02%s\x02-%s(%s)", ($i+1), $victim->getName(), $mount->getName());
			}
			return $player->msg('5130', array(ltrim($out, ',; ')));
// 			return $bot->reply(substr($out, 2));
		}
		
		if (false === ($target = Shadowfunc::getTarget($victims, $args[0], true)))
		{
			$player->msg('5128');
// 			$player->message('You see no mounts from other players to rob.');
			return false;
		}
		
		$mount = $target->getMount();
		
		if ($mount->getMountWeight() === 0)
		{
			$player->msg('1037');
// 			$player->message('This mount cannot store anything.');
			return false;
		}
		
		return $mount->initHijackBy($player);
	}
}
?>
