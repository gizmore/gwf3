<?php
/**
 * A user history entry.
 * This class replaced WC_HistoryUser.
 * @author gizmore
 */
final class WC_HistoryUser2 extends GDO
{
	public static $HISTORY_TYPES = array('link', 'unlink', 'gain', 'lost', 'ban', 'unban', 'unknown');
	const NO_XSS = 0x01;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_user_history2'; }
	public function getOptionsName() { return 'userhist_options'; }
	public function getColumnDefines()
	{
		return array(
			'userhist_uid' => array(GDO::OBJECT|GDO::INDEX, GDO::NOT_NULL, array('GWF_User', 'userhist_uid', 'user_id')),
			'userhist_date' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
		
			'userhist_sid' => array(GDO::OBJECT|GDO::INDEX, GDO::NOT_NULL, array('WC_Site', 'userhist_sid', 'site_id')), # siteid can be 0
			'userhist_percent' => array(GDO::UINT, GDO::NOT_NULL), # percent solved (same as onsitescore?)
			'userhist_onsitescore' => array(GDO::UINT, GDO::NOT_NULL), # onsitescore
		
			'userhist_rank' => array(GDO::UINT, GDO::NOT_NULL),
			'userhist_totalscore' => array(GDO::UINT, GDO::NOT_NULL),
		
			'userhist_gain_perc' => array(GDO::INT, GDO::NOT_NULL),
			'userhist_gain_score' => array(GDO::INT, GDO::NOT_NULL),
			'userhist_type' => array(GDO::ENUM, GDO::NOT_NULL, self::$HISTORY_TYPES),
		
			# v4.2
			'userhist_onsiterank' => array(GDO::UINT, 0),
			'userhist_options' => array(GDO::UINT, 0),
		
		);
	}

	###############
	### Display ###
	###############
	/**
	 * @return WC_Site
	 */
	public function getSite() { return $this->getVar('userhist_sid'); }
	public function displayDate() { return GWF_Time::displayTimestamp($this->getVar('userhist_date')); }
	public function displayPercent() { return sprintf('%.02f%%', $this->getVar('userhist_percent')/100); }
	public function displayComment() { return WC_HTML::lang('userhist_'.$this->getVar('userhist_type'), array($this->getSite()->displayName(), $this->getVar('userhist_gain_score'), sprintf('%.02f', $this->getVar('userhist_percent')/100), sprintf('%.02f', $this->getVar('userhist_gain_perc')/100) )); }
	public function displayUser() { return $this->getVar('userhist_uid')->displayProfileLink(); }
	##############
	### Static ###
	##############
	public static function insertEntry(GWF_User $user, WC_Site $site, $type, $onsitescore_new=0, $onsitescore_old=0, $scoregain=0, $onsiterank=0)
	{
		$uid = $user->getID();
		$user = GWF_User::getByIDNoCache($uid);
		$max = $site->getOnsiteScore();
		$perc_new = $max <= 0 ? 0 : round($onsitescore_new / $max * 10000);
		$perc_old = $max <= 0 ? 0 : round($onsitescore_old / $max * 10000);
		$perc_gain = $perc_new - $perc_old;
		$options = 0;
		$data = $user->getUserData();
		if (isset($data['WC_NO_XSS'])) {
			$options |= self::NO_XSS;
		}
		$entry = new self(array(
			'userhist_uid' => $uid,
			'userhist_date' => time(),
			'userhist_sid' => $site->getID(),
			'userhist_percent' => $perc_new,
			'userhist_onsitescore' => $onsitescore_new,
		
			'userhist_rank' => WC_RegAt::calcExactRank($user),
			'userhist_totalscore' => $user->getVar('user_level'),
		
			'userhist_gain_perc' => $perc_gain,
			'userhist_gain_score' => $scoregain,
			'userhist_type' => $type,
		
			'userhist_onsiterank' => $onsiterank,
			'userhist_options' => $options,
		
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