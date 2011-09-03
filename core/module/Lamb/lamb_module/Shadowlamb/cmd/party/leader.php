<?php
final class Shadowcmd_leader extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'leader'));
			return false;
		}
		
		$party = $player->getParty();
		if (false === ($target = $party->getMemberByArg($args[0])))
		{
			$bot->reply(sprintf('%s is not in your party.', $args[0]));
			return false;
		}
		
		if ($target->isLeader())
		{
			$bot->reply(sprintf('%s is already the party leader.', $target->getName()));
			return false;
		}
		
		if ($target->isNPC())
		{
			$bot->reply(sprintf('You can not give leadership to NPCs.'));
			return false;
		}
		
		switch ($party->getAction())
		{
			case SR_Party::ACTION_HIJACK:
			case SR_Party::ACTION_FIGHT:
				$bot->reply(sprintf('You cannot change leadership now.'));
				return false;
		}
		
		# Do it!
		if (false === $party->setLeader($target))
		{
			$bot->reply('Error.');
			return false;
		}
		
		$party->notice(sprintf('%s is the new party leader.', $target->getName()));
		return true;
	}
}
?>
