<?php
/**
 * Show current bounties, paginated
 * @author gizmore
 */
final class Shadowcmd_bounties extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		switch (count($args))
		{
			case 0:
				$page = 1;
				break;
				
			case 1:
				$page = (int)$args[0];
				break;
				
//			case 2:
//				$sid = (int)$args[0];
//				$page = (int)$args[1];

			default:
				return $bot->reply(Shadowhelp::getHelp($player, 'bounties'));
		}
		
		return self::rply($player, '5087', array(SR_Bounty::displayBounties($player, $page)));
// 		return $bot->reply(SR_Bounty::displayBounties($player, $page));
	}
}
?>