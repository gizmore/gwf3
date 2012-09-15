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
		
		$target = Shadowrun4::getPlayerByShortName($args[0]);
		if ($target === -1)
		{
			$player->message('The username is ambigious.');
			return false;
		}
		if ($target === false)
		{
			$player->message('The player is not in memory or unknown.');
			return false;
		}
		if (false === $target->isCreated())
		{
			$bot->reply(sprintf('The player %s has not started a game yet.', $args[0]));
			return false;
		}
		
		
		$npcnames = explode(',', $args[1]);
		foreach ($npcnames as $i => $npcname)
		{
			if (false === ($npc = Shadowrun4::getNPCByAbbrev($player, $npcname)))
			{
				$bot->reply(sprintf('Unknown NPC: %s.', $npcname));
				return false;
			}
			$npcnames[$i] = $npc->getNPCClassName();
		}
		
		
		$p = $target->getParty();
		$a = $p->getAction();
		$ep = NULL;
		
		switch ($a)
		{
			case SR_Party::ACTION_HIJACK:
			case SR_Party::ACTION_TRAVEL:
			case SR_Party::ACTION_DELETE:
				$bot->reply('Cannot #gmt because target action is '.$a.'!');
				return false;
			
			case SR_Party::ACTION_TALK:
				$p->getEnemyParty()->popAction(true);
			case SR_Party::ACTION_SLEEP:
				$p->popAction(false);
				break;

			case SR_Party::ACTION_FIGHT:
				$ep = $p->getEnemyParty();
				break;
				
			case SR_Party::ACTION_INSIDE:
			case SR_Party::ACTION_OUTSIDE:
			case SR_Party::ACTION_EXPLORE:
			case SR_Party::ACTION_GOTO:
			case SR_Party::ACTION_HUNT:
		}

// 		if ($a !== SR_Party::ACTION_INSIDE && $a !== SR_Party::ACTION_OUTSIDE) {
// 			$bot->reply('The party with '.$args[0].' is moving.');
// 			return false;
// 		}
	
		if (false === ($ep2 = SR_NPC::createEnemyParty($npcnames)))
		{
			$bot->reply('cannot create party! check logs');
			return false;
		}
		
		if ($ep === NULL)
		{
			$ep = $ep2;
		}
		else
		{
			$ep->mergeParty($ep2);
		}
		
		if ($p->isFighting())
		{
			$p->fight($ep, true);
		}
		elseif ($ep->getLeader() instanceof SR_TalkingNPC)
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
