<?php
final class Shadowcmd_look extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return self::executeLook($player, true);
	}
	
	public static function executeLook(SR_Player $player, $command_mode=true)
	{
		$bot = Shadowrap::instance($player);
		$p = $player->getParty();
		$pid = $player->getPartyID();
		
		$format = $player->lang('fmt_list');
		
		$back = '';
		foreach (Shadowrun4::getParties() as $party)
		{
			$party instanceof SR_Party;
			
			if ($party->getID() === $pid)
			{
				continue;
			}
			
			if (!$party->sharesLocation($p))
			{
				continue;
			}
			
			foreach ($party->getMembers() as $member)
			{
				$member instanceof SR_Player;
// 				if ($member->isHuman())
				{
					$back .= sprintf($format, $member->getName());
				}
			}
		}
		
		if ($back === '')
		{
			# You see no other players.
			return $command_mode ? $player->msg('5120') : true;
		}

// 		$player->setOption(SR_Player::RESPONSE_PLAYERS);
		
		# You see these players: %s.
		if ($command_mode)
		{
			$player->msg('5121', array(ltrim($back, ',; ')));
		}
		else
		{
			$player->msg('5121', array(ltrim($back, ',; ')));
		}
		
		return true;
	}
}
?>
