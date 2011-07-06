<?php
/**
 * Store when a player got 100% on a site.
 * Also display the duration / time taken from linking to 100%
 * @author gizmore
 */
final class WC_SiteMaster extends GDO
{
	const IS_OLD = 0x00;
	const IS_NEW = 0x01;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_master'; }
	public function getOptionsName() { return 'sitemas_options'; }
	public function getColumnDefines()
	{
		return array(
			'sitemas_uid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('GWF_User', 'sitemas_uid', 'user_id')),
			'sitemas_sid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('WC_Site', 'sitemas_sid', 'site_id')),
//			'sitemas_perc' => array(GDO::UINT|GDO::PRIMARY_KEY, 0), # 100, 90, ... We only use 100s atm
			'sitemas_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'sitemas_firstdate' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'sitemas_startperc' => array(GDO::UINT, 0),
			'sitemas_currperc' => array(GDO::DECIMAL, 0, array(1,8)),
			'sitemas_options' => array(GDO::UINT, 0),
		);
	}
	
	##################
	### Convinient ###
	##################
	/**
	 * @return GWF_User
	 */
	public function getUser() { return $this->getVar('sitemas_uid'); }
	/**
	 * @return WC_Site
	 */
	public function getSite() { return $this->getVar('sitemas_sid'); }
	
	###############
	### Display ###
	###############
	public function displayTrackTime()
	{
		$date1 = $this->getVar('sitemas_firstdate');
		$date2 = $this->getVar('sitemas_date');
		
		$timestamp1 = GWF_Time::getTimestamp($date1);
		$timestamp2 = GWF_Time::getTimestamp($date2);
		
		$diff = $timestamp2 - $timestamp1;
		
		return GWF_Time::humanDuration($diff, 2);
	}
	
	public function displayStartPerc()
	{
		return sprintf('%.02f%%', $this->getVar('sitemas_startperc') / 100);
	}
	
	public function displayCurrPerc()
	{
		return sprintf('%.02f%%', $this->getFloat('sitemas_currperc') * 100);
	}
	
	public function displayDate()
	{
		return GWF_Time::displayDate($this->getVar('sitemas_date'));
	}
	
	public function displayFirstDate()
	{
		return GWF_Time::displayDate($this->getVar('sitemas_firstdate'));
	}
	
	##############
	### Static ###
	##############
	/**
	 * Mark a user as a site-master. Return true on success; false on DB error.
	 * @param int $userid
	 * @param int $siteid
	 * @return boolean
	 */
	public static function markSiteMaster($userid, $siteid)
	{
		if (false === ($row = WC_HistoryUser2::getFirstRow($userid, $siteid))) {
			return false;
		}
		
		if (self::isSiteMaster($userid, $siteid)) {
			if (WECHALL_DEBUG_SCORING)
			{
				echo GWF_HTML::message('WeChall', 'Was already a Site Master!');
			}
			return true;
		}
		
		$entry = new self(array(
			'sitemas_uid' => $userid,
			'sitemas_sid' => $siteid,
			'sitemas_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND, WC_HistoryUser2::getMasterDate($userid, $siteid)),
			'sitemas_firstdate' => GWF_Time::getDate(GWF_Date::LEN_SECOND, $row->getVar('userhist_date')),
			'sitemas_startperc' => $row->getVar('userhist_percent'),
			'sitemas_currperc' => '1',
			'sitemas_options' => self::IS_NEW,
		
		));
		
		if (WECHALL_DEBUG_SCORING)
		{
			echo GWF_HTML::message('WeChall', 'Reached Site Master!');
		}
		
		return $entry->replace();
	}
	
	public static function isSiteMaster($userid, $siteid)
	{
		return self::table(__CLASS__)->getRow($userid, $siteid) !== false;
	}
	
	public static function unmarkSiteMaster($userid, $siteid, $curr_percent)
	{
		if (WECHALL_DEBUG_SCORING)
		{
			echo GWF_HTML::message('WeChall', 'Unmark Site Master!');
		}
		
		$curr_percent = (float) $curr_percent;
		
		$userid = (int)$userid;
		$siteid = (int)$siteid;
		return self::table(__CLASS__)->update("sitemas_options=sitemas_options-1, sitemas_currperc=$curr_percent", "sitemas_uid=$userid AND sitemas_sid=$siteid AND sitemas_options&1");
	}
	
	/**
	 * Get all masters within this $timestamp
	 * @param int $timestamp
	 * @return array
	 */
	public static function getMasters($timestamp)
	{
		$cut = GWF_Time::getDate(GWF_Date::LEN_SECOND, time()-$timestamp);
		return self::table(__CLASS__)->selectObjects('*', "sitemas_date>'$cut'", 'sitemas_date DESC');
	}
	
	public static function countMasters($timestamp)
	{
		$cut = GWF_Time::getDate(GWF_Date::LEN_SECOND, time()-$timestamp);
		return self::table(__CLASS__)->countRows("sitemas_date>'$cut'");
	}
	
}
?>
