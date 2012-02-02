<?php
final class Shadowcmd_gmprison extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'gmp'));
			return false;
		}

		if (false === ($target = Shadowrun4::getPlayerByShortName($args[0])))
		{
			$bot->reply(sprintf('The user %s is unknown.', $args[0]));
			return false;
		}
		elseif ($target === -1)
		{
			$bot->reply('The player name is ambigious.');
			return false;
		}
		
		if (false === $target->isCreated())
		{
			$bot->reply(sprintf('The player %s has not started a game yet.', $args[0]));
			return false;
		}
		
		$p = $target->getParty();
		$a = $p->getAction();
		if ($a !== SR_Party::ACTION_INSIDE && $a !== SR_Party::ACTION_OUTSIDE)
		{
			$bot->reply('The party with '.$args[0].' is moving.');
			return false;
		}
		
		$p->pushAction(SR_Party::ACTION_INSIDE, 'Prison_Block1');
		
	}
}
?>
