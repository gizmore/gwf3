<?php
/**
 * Clan memberlist
 * @author gizmore
 * @TODO: Ranks
 */
final class SR_ClanMembers extends GDO
{
	const FOUNDER = 0x01;
	const RECRUITER = 0x02;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_clan_members'; }
	public function getOptionsName() { return 'sr4cm_options'; }
	public function getColumnDefines()
	{
		return array(
			'sr4cm_pid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4cm_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4cm_jointime' => array(GDO::UINT, GDO::NOT_NULL),
			'sr4cm_options' => array(GDO::UINT, 0),
			
			'clans' => array(GDO::JOIN, GDO::NULL, array('SR_Clan', 'sr4cm_cid', 'sr4cl_id')),
			'players' => array(GDO::JOIN, GDO::NULL, array('SR_Player', 'sr4cm_pid', 'sr4pl_id')),
		);
	}
	
	/**
	 * Get a clan by playerid.
	 * @param int $pid
	 * @return SR_Clan
	 */
	public static function getClanByPID($pid)
	{
		$pid = (int)$pid;
		echo "TRY PID $pid\n";
		return self::table(__CLASS__)->selectFirst('clans.*', "sr4cm_pid={$pid}", '', array('clans'), 'SR_Clan');
	}
	
	/**
	 * Get a clan by playerid.
	 * @param int $pid
	 * @return SR_Clan
	 */
	public static function getClanByPName($pname)
	{
		if (false === ($player = Shadowrun4::getPlayerByShortName($pname)))
		{
			return false;
		}
		elseif ($player === -1)
		{
			return false;
		}
		return self::getClanByPID($player->getID());
	}
	
	/**
	 * Calculate membercount for a clan.
	 * @param int $cid
	 * @return int
	 */
	public static function countMembers($cid)
	{
		$cid = (int)$cid;
		return self::table(__CLASS__)->countRows("sr4cm_cid={$cid}");
	}
	
	/**
	 * Get all online members for a clan.
	 * @param int $cid
	 * @return array
	 */
	public static function getOnlineMembers($cid)
	{
		$back = array();
		$cid = (int)$cid;
		foreach (self::table(__CLASS__)->selectColumn('sr4cm_pid', "sr4cm_cid={$cid}") as $playerid)
		{
			if (false !== ($player = Shadowrun4::getPlayerByPID($playerid)))
			{
				$back[] = $player;
			}
		}
		return $back;
	}
	
	/**
	 * Compute the leader by time.
	 * @param int $cid
	 */
	public static function computeLeaderID($cid)
	{
		$cid = (int)$cid;
		return self::table(__CLASS__)->selectVar('sr4cm_pid', "sr4cm_cid={$cid}", 'sr4cm_time ASC', NULL);
	}
	
	/**
	 * Remove a row from memberlist.
	 * @param int $cid
	 * @param int $pid
	 * @return boolean
	 */
	public static function removeMember($cid, $pid)
	{
		$row = new self(array('sr4cm_pid'=>$pid,'sr4cm_cid'=>$cid));
		return $row->delete();
	}
	
	/**
	 * Toggle clanbit options.
	 * @param int $cid
	 * @param int $pid
	 * @param int $bits
	 * @param boolean $enabled
	 * @return boolean
	 */
	public static function setClanOptions($cid, $pid, $bits, $enabled=true)
	{
		return self::table(__CLASS__)->getRow($pid, $cid)->saveOption($bits, $enabled);
	}
}
?>