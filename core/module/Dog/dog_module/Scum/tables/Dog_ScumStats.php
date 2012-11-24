<?php
final class Dog_ScumStats extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_scum_stats'; }
	public function getColumnDefines()
	{
		return array(
			'scums_userid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'scums_games' => array(GDO::UINT, 0),
			'scums_won' => array(GDO::UINT, 0),
			'scums_score' => array(GDO::UINT, 0),
		);
	}
	
	public function getGames() { return $this->getVar('scums_games'); }
	public function getWon() { return $this->getVar('scums_won'); }
	public function getScore() { return $this->getVar('scums_score'); }
		
	/**
	 * @param int $userid
	 * @return Dog_ScumStats
	 */
	private static function getOrCreateStatsRow($userid)
	{
		$userid = (int) $userid;
		if (false === ($row = self::getStatsRow($userid))) {
			return self::createStatsRow($userid);
		}
		return $row;
	}
	
	public static function getStatsRow($userid)
	{
		return self::table(__CLASS__)->getRow($userid);
	}
	
	/**
	 * @param int $userid
	 * @return Dog_ScumStats
	 */
	private static function createStatsRow($userid)
	{
		$row = new self(array(
			'scums_userid' => $userid,
			'scums_games' => 0,
			'scums_won' => 0,
			'scums_score' => 0,
		));
		if (false === ($row->insert())) {
			return false;
		}
		return $row;
	}
	
	public static function updateScumStats(Dog_ScumGame $game)
	{
		$server = $game->getServer();
		
		$won = 1;
		$score = $game->getPlayerCountStart();
		foreach ($game->getWinners() as $name)
		{
			$score--;
			if (false === ($user = $server->getUserByNickname($name)))
			{
				Dog_Log::error('Can not find user '.$name);
				continue;
			}
			
			$userid = $user->getID();
			if (false === ($row = (self::getOrCreateStatsRow($userid))))
			{
				Dog_Log::error('Can not find stats for user '.$name);
				continue;
			}
			$row->updateRow("scums_games=scums_games+1, scums_won=scums_won+$won, scums_score=scums_score+$score");
			$won = 0;
		}
		
	}
}
?>