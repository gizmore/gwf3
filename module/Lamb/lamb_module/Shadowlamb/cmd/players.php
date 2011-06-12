<?php
final class Shadowcmd_players extends Shadowcmd
{
	const PPP = 10; # Players Per Page
	
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) !== 1)
		{
			$player->message(Shadowhelp::getHelp($player, 'players'));
			return false;
		}
		
		$ppp = self::PPP;

		$page = (int) $args[0];
		$players = Shadowrun4::getPlayers();
		$nPlayers = count($players);
		$nPages = GWF_PageMenu::getPagecount($ppp, $nPlayers);
		$from = GWF_PageMenu::getFrom($page, $ppp);
		
		if ( ($page < 1) || ($page > $nPages) )
		{
			$player->message(sprintf('Page %d of %d is empty.', $page, $nPages));
			return false;
		}
		
		$out = '';
		foreach (array_slice($players, $from, $ppp, false) as $p)
		{
			$p instanceof SR_Player;
			$out .= sprintf(', %s', $p->displayName());
		}

		$out = $out === '' ? 'This page is empty.' : sprintf('Active players (page %d of %d): %s.', $page, $nPages, substr($out, 2));
		
		self::reply($player, $out);
		
		return true;
	}
}
?>