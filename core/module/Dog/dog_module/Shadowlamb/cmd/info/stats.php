<?php
final class Shadowcmd_stats extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$parties = $human = $npc = 0;
		foreach (Shadowrun4::getParties() as $party)
		{
			$parties++;
			foreach ($party->getMembers() as $member)
			{
				if ($member->isHuman())
				{
					$human++;
				}
				else
				{
					$npc++;
				}
			}
		}
		return $bot->rply('5244', array($human, $npc, $parties));
// 		$bot->reply(sprintf('Currently there are %s Human, %s NPC and %s parties in memory.', $human, $npc, $parties));
// 		return true;
	}
}
?>