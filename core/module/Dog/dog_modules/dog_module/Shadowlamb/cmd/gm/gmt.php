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
		
		# Check for valid enemies.
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
		
		# Prepare for action cases
		$p = $target->getParty();
		$a = $p->getAction();
		$ep = NULL;
		switch ($a)
		{
			case SR_Party::ACTION_TALK:
				$p->getEnemyParty()->popAction(true); # we pop the enemies talking
			case SR_Party::ACTION_SLEEP:
				$p->popAction(false); # and pop our own fallthrough
				break;

			case SR_Party::ACTION_FIGHT:
				$ep = $p->getEnemyParty(); # Stack and re-init the fight :)
				break;
				
			# Nothing todo here
			case SR_Party::ACTION_INSIDE:
			case SR_Party::ACTION_OUTSIDE:
			case SR_Party::ACTION_EXPLORE:
			case SR_Party::ACTION_GOTO:
			case SR_Party::ACTION_HUNT:
				break;

			# Impossibru
			case SR_Party::ACTION_HIJACK:
			case SR_Party::ACTION_TRAVEL:
			case SR_Party::ACTION_DELETE:
			default:
				$bot->reply('Cannot #gmt because target action is '.$a.'!');
				return false;
		}
	
		# Generate NPCs
		if (false === ($ep2 = SR_NPC::createEnemyParty($npcnames)))
		{
			$bot->reply('cannot create party! check logs');
			return false;
		}
		
		# Merge?
		if ($ep === NULL)
		{
			$ep = $ep2;
		}
		else
		{
			$ep->mergeParty($ep2);
		}
		
		# Delegate new actions
		if ($p->isFighting())
		{
			# Already fighting
			$p->popAction(false);
			$p->fight($ep, true);
		}
		elseif ($ep->getLeader() instanceof SR_TalkingNPC)
		{
			# Init a talk
			$p->talk($ep, true);
		}
		else
		{
			# Init a fight
			$p->fight($ep, true);
		}
		
		# That's it!
		return $bot->reply('The party now encountered some enemies!');
	}
}
?>
