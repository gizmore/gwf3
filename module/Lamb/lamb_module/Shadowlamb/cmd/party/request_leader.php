<?php
final class Shadowcmd_request_leader extends Shadowcmd
{
	const RL_TIME = 600; # Request_Leader_Time
	
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (!$player->getParty()->isIdle()) {
			$player->message('Your party needs to be idle to request a new leader.');
			return false;
		}
		
		if ($player->isLeader()) {
			$bot->reply('You are already leader of your party.');
			return false;
		}

		$party = $player->getParty();
		$leader = $party->getLeader();
		$user = $leader->getUser();
		$last = $user->getVar('lusr_timestamp');
		$wait = ($last+self::RL_TIME) - time();
		if ($wait > 0) {
			$bot->reply(sprintf('Please wait %s and try again.', GWF_Time::humanDuration($wait)));
			return true;
		}
		
		if (false === $party->setLeader($player)) {
			$bot->reply('Error.');
			return false;
		}
		$party->notice(sprintf('%s is the new party leader.', $player->getName()));
		return true;
	}
}
?>
