<?php
/**
 * Clan information functions that always work. 
 * @author gizmore
 */
final class Shadowcmd_clan extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		# Own info
		if (count($args) === 0)
		{
			return self::showClanInfo($player, $player);
		}
		
		# 1 Numeric == clan history.
		if ( (count($args) === 1) && Common::isNumeric($args[0]))
		{
			if ($args[0] < 1)
			{
				$bot->reply(Shadowhelp::getHelp($player, 'clan'));
				return false;
			}
			
			return self::showHistoryPage($player, (int)$args[0]);
		}

		# !members shows your clan members.
		if ( (count($args) === 1) || (count($args) === 2) )
		{
			if ( ($args[0] === '!m') || ($args[0] === '!members') )
			{
				$page = isset($args[1]) ? (int)$args[1] : 1;
				return self::showMembers($player, $page);
			}
		}
		
		# Show another player.
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'clan'));
			return false;
		}
		if (false === ($target = Shadowrun4::getPlayerByShortName($args[0])))
		{
			$bot->reply('This player is unknown or not in memory.');
			return false;
		}
		else if ($target === -1)
		{
			$bot->reply('This playername is ambigous.');
			return false;
		}
		return self::showClanInfo($player, $target);
	}
	
	/**
	 * Show clan statistics for a player.
	 * @param SR_Player $player
	 * @param SR_Player $target
	 */
	private static function showClanInfo(SR_Player $player, SR_Player $target)
	{
		$bot = Shadowrap::instance($player);
		
		if (false === ($clan = SR_Clan::getByPlayer($target)))
		{
			$bot->reply(sprintf('Player %s does not belong to a clan yet.', $target->getName()));
			return false;
		}
		$message = sprintf(
			'%s is in the "%s" clan with %s/%s members, %s/%s wealth and %s/%s in the bank. Their motto: %s',
			$target->getName(), $clan->getName(),
			$clan->getMembercount(), $clan->getMaxMembercount(),
			$clan->displayNuyen(), $clan->displayMaxNuyen(),
			$clan->displayStorage(), $clan->displayMaxStorage(),
			$clan->getSlogan()
		);
		return $bot->reply($message);
	}
	
	/**
	 * Show one member page for your clan.
	 * @param SR_Player $player
	 * @param int $page
	 */
	private static function showMembers(SR_Player $player, $page)
	{
		if ($page < 1)
		{
			$player->message(Shadowhelp::getHelp($player, 'clan'));
			return false;
		}
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->message('You are not in a clan, chummer.');
			return false;
		}
		$ipp = 10;
		$nItems = $clan->getMembercount();
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		if ($page > $nPages)
		{
			$player->message('This page is empty.');
			return false;
		}
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$where = 'sr4cm_cid='.$clan->getID();
		$orderby = 'sr4cm_jointime ASC';
		if (false === ($members = GDO::table('SR_ClanMembers')->selectAll('sr4pl_name, sr4pl_sid, sr4pl_level', $where, $orderby, array('players'), $ipp, $from, GDO::ARRAY_N)))
		{
			$player->message('DB ERROR 1');
			return false;
		}
		if (count($members) === 0)
		{
			$player->message('This page is empty.');
			return false;
		}
		$back = '';
		foreach ($members as $row)
		{
			$from++;
			$back .= sprintf(', %d-%s{%s}(L%s)', $from, $row[0], $row[1], $row[2]);
		}
		return Shadowrap::instance($player)->reply(sprintf('%d ClanMembers page %d/%d: %s.', $nItems, $page, $nPages, substr($back, 2)));
	}
	
	/**
	 * Show one history page for your clan.
	 * @param SR_Player $player
	 * @param int $page
	 */
	private static function showHistoryPage(SR_Player $player, $page)
	{
		$bot = Shadowrap::instance($player);
		
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$bot->reply('You don\'t belong to a clan yet.');
			return false;
		}
		
		$ipp = 5;
		$table = GDO::table('SR_ClanHistory');
		$where = 'sr4ch_cid='.$clan->getID();
		$nItems = $table->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		if ($page > $nPages)
		{
			$bot->reply('This page is empty.');
			return false;
		}
		$from = GWF_PageMenu::getFrom($page, $ipp);
		if (false === ($result = $table->selectAll('sr4ch_time,sr4ch_pname,sr4ch_action,sr4ch_iname,sr4ch_amt', $where, 'sr4ch_time DESC', NULL, $ipp, $from, GDO::ARRAY_N)))
		{
			$bot->reply('DB ERROR');
			return false;
		}

		$b = 0;
		$out = array();
		foreach ($result as $row)
		{
			$b = 1 - $b;
			$b2 = $b === 0 ? '' : "\X02";
			$out[] = $b2.SR_ClanHistory::getHistMessage($row[0], $row[1], $row[2], $row[3], $row[4]).$b2;
		}
		
		$message = sprintf('ClanHistory page %d/%d: %s', $page, $nPages, implode('  ', $out));
		return $bot->reply($message);
	}
}
?>