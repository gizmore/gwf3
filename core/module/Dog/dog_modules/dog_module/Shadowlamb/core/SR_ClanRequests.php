<?php
final class SR_ClanRequests extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_clan_requests'; }
	public function getColumnDefines()
	{
		return array(
			'sr4cr_pid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4cr_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4cr_pname' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, GDO::NOT_NULL, 63),
		);
	}
	
	/**
	 * Check if a player is applying to some clan.
	 * @param SR_Player $player
	 */
	public static function hasOpenRequests(SR_Player $player)
	{
		$pid = $player->getID();
		return self::table(__CLASS__)->countRows("sr4cr_pid={$pid}") > 0;
	}
	
	public static function clearRequests(SR_Player $player)
	{
		$pid = $player->getID();
		return self::table(__CLASS__)->deleteWhere("sr4cr_pid={$pid}");
	}
	
	/**
	 * Get the player for a join request.
	 * @param SR_Player $leader
	 * @param SR_Clan $clan
	 * @param string $pname
	 * @return SR_Player
	 */
	public static function getRequest(SR_Player $leader, SR_Clan $clan, $pname)
	{
		$ename = GDO::escape($pname);
		if (false === ($pid = self::table(__CLASS__)->selectVar('sr4cr_pid', "sr4cr_pname='{$ename}'")))
		{
			return false;
		}
		if (false === ($player = Shadowrun4::getPlayerByPID($pid)))
		{
			if (false === ($player = SR_Player::getByID($pid)))
			{
				return false;
			}
		}
		return $player;
	}
	
}
?>