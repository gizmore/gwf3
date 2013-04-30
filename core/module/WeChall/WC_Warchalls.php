<?php
/**
 * @deprecated
 * @author gizmore
 */
final class WC_Warchalls extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_warchalls'; }
	public function getColumnDefines()
	{
		return array(
			'wc_wcid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'wc_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'wc_solved_at' => array(GDO::DATE, GDO::NOT_NULL, 14),
		);
	}
	
	public function getSolverCount(WC_Warchall $warchall)
	{
		return self::table(__CLASS__)->selectVar('COUNT(*)', "wc_wcid={$warchall->getID()}");
	}
	
	public static function hasSolved(GWF_User $user, WC_Warchall $chall)
	{
		return self::table(__CLASS__)->selectVar('1', "wc_wcid={$chall->getID()} AND wc_uid={$user->getID()}") !== false;
	}

	public static function markSolved(GWF_User $user, WC_Warchall $chall)
	{
		if (!self::table(__CLASS__)->insertAssoc(array(
			'wc_wcid' => $chall->getID(),
			'wc_uid' => $user->getID(),
			'wc_solved_at' => GWF_Time::getDate(14),
		)))
		{
			return false;
		}
		return true;
	}
}
?>
