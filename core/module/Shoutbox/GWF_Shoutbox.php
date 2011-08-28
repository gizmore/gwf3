<?php
/**
 * Shoutbox msg
 * @author gizmore
 */
final class GWF_Shoutbox extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'shoutbox'; }
	public function getColumnDefines()
	{
		return array(
			'shout_id' => array(GDO::AUTO_INCREMENT),
			'shout_uid' => array(GDO::OBJECT|GDO::INDEX, 0, array('GWF_User', 'shout_uid', 'user_id')),
			'shout_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'shout_uname' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'shout_message' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
		);
	}
	
	##################
	### Convinient ###
	##################
	/**
	 * @return GWF_User
	 */
//	public function getUID() { return $this->getVar('shout_uid'); }
//	public function getUser() { return GWF_User::getByID($this->getVar('shout_uid')); }
	public function getUID() { return $this->getUser()->getID(); }
	public function getUser() { return $this->getVar('shout_uid'); }
	public function isGuestShout() { return $this->getUID() === 0; }
	
	
	###############
	### Display ###
	###############
	public function displayUsername()
	{
		$uname = $this->getVar('shout_uname');
		if ($this->isGuestShout())
		{
			return $uname;
//			return GWF_HTML::lang('guest').'_'.$uname;
		}
		return GWF_HTML::anchor(GWF_WEB_ROOT.'profile/'.urlencode($uname), GWF_HTML::display($uname));
	}
	
	public function displayMessage()
	{
		return GWF_Message::display($this->getVar('shout_message'), false, true, false);
	}
	
	public function displayDate()
	{
		return GWF_Time::displayDate($this->getVar('shout_date'));
	}
	##############
	### Static ###
	##############
	/**
	 * @param int $shoutid
	 * @return GWF_Shoutbox
	 */
	public static function getByID($shoutid)
	{
		return self::table(__CLASS__)->getRow($shoutid);
	}
	
	public static function generateUsername()
	{
		if (false !== ($user = GWF_Session::getUser())) {
			return $user->getVar('user_name');
		}
		else {
			return abs(crc32($_SERVER['REMOTE_ADDR']));
		}
	}
}
?>