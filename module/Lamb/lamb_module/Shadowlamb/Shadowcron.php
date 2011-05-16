<?php
final class Shadowcron
{
	public static function onCronjob()
	{
		echo __METHOD__.PHP_EOL;
		self::cleanupParties();
		self::cleanupPlayers();
		self::cleanupItems();
	}
	
	private static function cleanupParties()
	{
		echo __METHOD__.PHP_EOL;
		$parties = GDO::table('SR_Party');
		$before = $parties->countRows();
		if (false === ($result = $parties->select('sr4pa_id'))) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return;
		}
		$sr_time = Shadowrun4::getTime();
		while (false !== ($row = $parties->fetch($result, GDO::ARRAY_N)))
		{
			if (false !== ($party = SR_Party::getByID($row[0])))
			{
				$party->timer($sr_time);
			}
		}
		$parties->free($result);
		$after = $parties->countRows();
		printf("I removed %s parties from the database and %s are left.\n", $before-$after, $after);
		
	}
	
	private static function cleanupPlayers()
	{
		echo __METHOD__.PHP_EOL;
		$players = GDO::table('SR_Player');
		$before = $players->countRows();
		if (false === ($result = $players->select('sr4pl_id, sr4pl_partyid'))) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return;
		}
		$sr_time = Shadowrun4::getTime();
		while (false !== ($row = $players->fetch($result, GDO::ARRAY_N)))
		{
			if (false !== ($player = SR_Player::getByID($row[0])))
			{
				if (false === (SR_Party::getByID($player->getPartyID())))
				{
					if ($player->isHuman())
					{
						printf("WARNING: %s has not party!!\n", $player->getName());
					}
					else
					{
						$player->delete();
					}
				}
			}
		}
		$players->free($result);
		$after = $players->countRows();
		printf("I removed %s players from the database and %s are left.\n", $before-$after, $after);
	}
	
	private static function cleanupItems()
	{
		echo __METHOD__.PHP_EOL;
		$players = GDO::table('SR_Player');
		$pids = $players->selectColumn('sr4pl_id');
		$items = GDO::table('SR_Item');
		$before = $items->countRows();
		if (false === ($result = $items->select('sr4it_id, sr4it_uid'))) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return;
		}
		$sr_time = Shadowrun4::getTime();
		while (false !== ($row = $items->fetch($result, GDO::ARRAY_N)))
		{
			if (!in_array($row[1], $pids, true))
			{
				$items->deleteWhere("sr4it_id={$row[0]}");
			}
		}
		$items->free($result);
		$after = $items->countRows();
		printf("I removed %s items from the database and %s are left.\n", $before-$after, $after);
	}
}
?>