<?php
/**
 * Ban entry.
 * @author gizmore
 */
final class GWF_Ban extends GDO
{
	const TYPE_BAN = 0x01;
	const TYPE_WARNING = 0x02;
	const READ = 0x04;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'ban'; }
	public function getOptionsName() { return 'ban_options'; }
	public function getColumnDefines()
	{
		return array(
			'ban_id' => array(GDO::AUTO_INCREMENT),
			'ban_uid' => array(GDO::OBJECT|GDO::INDEX, GDO::NOT_NULL, array('GWF_User', 'ban_uid', 'user_id')),
			'ban_msg' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'ban_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'ban_ends' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'ban_options' => array(GDO::UINT, GDO::NOT_NULL),
		);
	}
	
	##################
	### Convinient ###
	##################
	/**
	 * @return GWF_User
	 */
	public function getUser() { return $this->getVar('ban_uid'); }
	public function getType() { return $this->getVar('ban_options') & 0x03; }
	public function isBan() { return $this->getType() === self::TYPE_BAN; }
	public function isWarning() { return $this->getType() === self::TYPE_WARNING; }
	public function isPermanent() { return $this->getVar('ban_ends') === ''; }
	
	###############
	### Display ###
	###############
	public function displayDate()
	{
		return GWF_Time::displayDate($this->getVar('ban_date'));
	}
	
	public function displayEndDate()
	{
		if ($this->isWarning()) {
			return '';
		}
		elseif ('' === ($ends = $this->getVar('ban_ends'))) {
			return GWF_HTML::lang('never');
		}
		else {
			return GWF_Time::displayDate($ends);
		}
	}
	
	##################
	### Static Get ###
	##################
	/**
	 * @param int $banid
	 * @return GWF_Ban
	 */
	public static function getByID($banid)
	{
		return self::table(__CLASS__)->getRow($banid);
	}
	
	/**
	 * Get all current bans/warnings for a user. Returns array of GWF_Ban
	 * @param int $userid
	 * @return array
	 */
	public static function getUnread($userid)
	{
		$userid = (int) $userid;
		$now = GWF_Time::getDate(GWF_Date::LEN_SECOND);
		return self::table(__CLASS__)->selectObjects('*', "ban_uid=$userid AND ban_options&4=0 AND (ban_ends='' OR ban_ends>'$now') ", 'ban_date ASC');
	}
	
	
	#####################
	### Static Insert ###
	#####################
	/**
	 * Insert a warning.
	 * @param int $userid
	 * @param string $msg
	 * @return boolean
	 */
	public static function insertWarning($userid, $msg='You got warned!')
	{
		return self::insertBanEntry($userid, '', $msg, self::TYPE_WARNING);
	}
	
	/**
	 * Insert a ban. End Date of '' means perm.
	 * @param int $userid
	 * @param string $ends gdo date
	 * @param string $msg
	 * @return boolean
	 */
	public static function insertBan($userid, $ends='', $msg='You got banned!')
	{
		return self::insertBanEntry($userid, $ends, $msg, self::TYPE_BAN);
	}
	
	# private insertion of entry
	private static function insertBanEntry($userid, $ends, $msg, $options)
	{
		$entry = new self(array(
			'ban_id' => 0,
			'ban_uid' => $userid,
			'ban_msg' => $msg,
			'ban_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'ban_ends' => $ends,
			'ban_options' => $options,
		));
		return $entry->insert();
	}
}

?>