<?php
final class Shadowcmd_parties extends Shadowcmd
{
	const PPP = 10; # Parties Per Page
	
	public static function execute(SR_Player $player, array $args)
	{
		$pp = Shadowrun4::getParties();
		foreach ($pp as $i => $p)
		{
			$p instanceof SR_Party;
			if (!$p->isHuman())
			{
				unset($pp[$i]);
			}
		}
		
		$page = isset($args[0]) ? intval($args[0]) : 1;
		$nItems = count($pp);
		$nPages = GWF_PageMenu::getPagecount(self::PPP, $nItems);
		$page = Common::clamp($page, 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, self::PPP);
		$slice = array_slice($pp, $from, self::PPP);
		
		$out = '';
		$format = $player->lang('fmt_list');
		foreach ($slice as $p)
		{
			$p instanceof SR_Party;
			$leader = $p->getLeader()->displayName();
			$l = $p->getSum('level', true);
			$ll = $p->getSum('level', false);
			$mc = $p->getMemberCount();
			$item = sprintf('%s(L%s(%s))(M%s)', $leader, $l, $ll, $mc);
			$out .= sprintf($format, $item);
// 			$out .= sprintf(', %s(L%s(%s))(M%s)', $leader, $l, $ll, $mc);
		}
		return self::rply($player, '5248', array($page, $nPages, substr($out, 2)));
// 		$bot = Shadowrap::instance($player);
// 		$bot->reply(sprintf('Parties page %s from %s: %s.', $page, $nPages, substr($out, 2)));
	}
}
?>