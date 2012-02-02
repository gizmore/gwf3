<?php
final class Shadowcmd_request_leader extends Shadowcmd
{
	const RL_TIME = 600; # Request_Leader_Time
	
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (!$player->getParty()->isIdle())
		{
			$player->msg('1033');
// 			return $player->message('Your party needs to be idle to request a new leader.');
		}
		
		if ($player->isLeader())
		{
			$player->msg('1095');
// 			return $bot->reply('You are already leader of your party.');
		}

		$party = $player->getParty();
		$leader = $party->getLeader();
		$user = $leader->getUser();
		$last = $user->getVar('lusr_timestamp');
		$wait = ($last+self::RL_TIME) - time();
		
		if ($leader->isOptionEnabled(SR_Player::NO_RL))
		{
			self::rply($player, '1096');
// 			return $bot->reply('Your leader does not allow to takeover the leadership.');
		}
		
		if ($wait > 0)
		{
			self::rply($player, '1097', array(GWF_Time::humanDuration($wait)));
// 			return $bot->reply(sprintf('Please wait %s and try again.', GWF_Time::humanDuration($wait)));
		}
		
		
		if (false === $party->setLeader($player))
		{
			return $bot->reply('Error.');
		}
		
		return $party->ntice('5138', array($player->getName()));
// 		return $party->notice(sprintf('%s is the new party leader.', $player->getName()));
	}
}
?>
