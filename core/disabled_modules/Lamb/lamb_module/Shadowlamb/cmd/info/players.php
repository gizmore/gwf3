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
			$player->msg('1009');
// 			$player->message(sprintf('Page %d of %d is empty.', $page, $nPages));
			return false;
		}
		
		$out = '';
		$format = $player->lang('fmt_sumlist');
		foreach (array_slice($players, $from, $ppp, false) as $p)
		{
			$p instanceof SR_Player;
			$summand = sprintf('L%s(%s)', $p->getBase('level'), $p->get('level'));
			$out .= sprintf($format, $p->getEnum(), $p->getName(), $summand);
// 			$out .= sprintf(', %s(L%s(%s))', $p->displayName(), $p->getBase('level'), $p->get('level'));
		}
		
		if ($out === '')
		{
			$player->msg('1009');
			return false;
		}

		return self::rply($player, '5247', array($page, $nPages, ltrim($out, ',; ')));
// 		$out = $out === '' ? 'This page is empty.' : sprintf('Active players (page %d of %d): %s.', $page, $nPages, substr($out, 2));
		
// 		self::reply($player, $out);
		
// 		return true;
	}
}
?>