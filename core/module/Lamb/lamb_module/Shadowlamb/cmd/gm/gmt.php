<?php
final class Shadowcmd_gmt extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 2) {
			$bot->reply(Shadowhelp::getHelp($player, 'gmt'));
			return false;
		}
		
		$server = $player->getUser()->getServer();
		if (false === ($user = $server->getUserByNickname($args[0]))) {
			$bot->reply(sprintf('The user %s is unknown.', $args[0]));
			return false;
		}
		if (false === ($target = Shadowrun4::getPlayerForUser($user))) {
			$bot->reply(sprintf('The player %s is unknown.', $args[0]));
			return false;
		}
		if (false === $target->isCreated())
		{
			$bot->reply(sprintf('The player %s has not started a game yet.', $args[0]));
			return false;
		}

		$p = $target->getParty();
		$a = $p->getAction();
		if ($a !== SR_Party::ACTION_INSIDE && $a !== SR_Party::ACTION_OUTSIDE) {
			$bot->reply('The party with '.$args[0].' is moving.');
			return false;
		}
	
		if (false === ($ep = SR_NPC::createEnemyParty(explode(',', $args[1])))) {
			$bot->reply('cannot create party! check logs');
			return false;
		}
		
		if ($ep->getLeader() instanceof SR_TalkingNPC)
		{
			$p->talk($ep, true);
		}
		else
		{
			$p->fight($ep, true);
		}
		
		$bot->reply('The party now encountered some enemies!');
		
		return true;
	}
}
?>
