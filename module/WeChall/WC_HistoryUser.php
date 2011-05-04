<?php
/**
 * Site History entries.
 * @author Kender, gizmore
 */
final class WC_HistoryUser extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_user_history'; }
	public function getColumnDefines()
	{
		return array(
			'userhist_uid' => array(GDO::OBJECT|GDO::INDEX, GDO::NOT_NULL, array('GWF_User', 'userhist_uid')),
//			'userhist_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'userhist_date' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
		
			'userhist_sid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL), # siteid can be 0
			'userhist_percent' => array(GDO::UINT, GDO::NOT_NULL), # percent solved (same as onsitescore?)
			'userhist_onsitescore' => array(GDO::UINT, GDO::NOT_NULL), # onsitescore
		
			'userhist_rank' => array(GDO::UINT, GDO::NOT_NULL),
			'userhist_totalscore' => array(GDO::UINT, GDO::NOT_NULL),

			'userhist_comment' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
		);
	}
	
	###############
	### Display ###
	###############
	public function displayDate() { return GWF_Time::displayTimestamp($this->getVar('userhist_date')); }
	public function displayComment() { return $this->display('userhist_comment'); }
	public function displayPercent() { return sprintf('%.02f%%', $this->getVar('userhist_percent')/100); }
	
	public static function insertEntry(GWF_User $user, WC_Site $site, $onsitescore, $comment)
	{
		$user = GWF_User::getByIDNoCache($user->getID());
		$max = $site->getOnsiteScore();
		$perc = $max <= 0 ? 0 : round($onsitescore / $max * 10000);
		$entry = new self(array(
			'userhist_uid' => $user->getVar('user_id'),
			'userhist_date' => time(), #GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'userhist_sid' => $site->getVar('site_id'),
			'userhist_percent' => $perc,
			'userhist_onsitescore' => $onsitescore,
			'userhist_rank' => WC_RegAt::calcRank($user),
			'userhist_totalscore' => $user->getVar('user_level'),
			'userhist_comment' => $comment,
		));
		if (WECHALL_DEBUG_SCORING)
		{
			echo WC_HTML::message('Inserting User History entry...');
		}
		return $entry->insert();
	}
	
	public static function getFirstDate($userid, $siteid)
	{
		$userid = (int) $userid;
		$siteid = (int) $siteid;
		return self::table(__CLASS__)->selectMin('userhist_date', "userhist_uid=$userid AND userhist_sid=$siteid");
	}

	public static function getMasterDate($userid, $siteid)
	{
		$userid = (int) $userid;
		$siteid = (int) $siteid;
		return self::table(__CLASS__)->selectMin('userhist_date', "userhist_uid=$userid AND userhist_sid=$siteid AND userhist_percent>=10000");
	}

	/**
	 * Get the first Row for a user/site.
	 * @param $userid
	 * @param $siteid
	 * @return WC_HistoryUser
	 */
	public static function getFirstRow($userid, $siteid)
	{
		$userid = (int) $userid;
		$siteid = (int) $siteid;
		return self::table(__CLASS__)->selectFirst("userhist_uid=$userid AND userhist_sid=$siteid", "userhist_date ASC");
	}
}

?>