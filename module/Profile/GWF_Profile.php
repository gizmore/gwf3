<?php
/**
 * A User Profile
 * @author gizmore
 * @version 1.0
 */
final class GWF_Profile extends GDO
{
//	const HIDDEN = 0x01;
	const HIDE_EMAIL = 0x02;
	const HIDE_COUNTRY = 0x04;
//	const SHOW_BIRTHDAY = 0x08;
	const HIDE_GUESTS = 0x10;
	const HIDE_ROBOTS = 0x20;
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'profile'; }
	public function getOptionsName() { return 'prof_options'; }
	public function getColumnDefines()
	{
		return array(
			'prof_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'prof_views' => array(GDO::UINT, 0),
			'prof_about_me' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'prof_options' => array(GDO::UINT, 0),
		
			'prof_website' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
		
			'prof_level_all' => array(GDO::UINT, 0),
			'prof_level_contact' => array(GDO::UINT, 0),
		
			'prof_firstname' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 63),
			'prof_lastname' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 63),
			'prof_street' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 63),
			'prof_zip' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 16),
			'prof_city' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 63),
		
			'prof_tel' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 32),
			'prof_mobile' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 32),
		
			'prof_icq' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 16),
			'prof_msn' => array(GDO::VARCHAR|GDO::CASE_I|GDO::ASCII, '', GWF_User::EMAIL_LENGTH),
			'prof_jabber' => array(GDO::VARCHAR|GDO::CASE_I|GDO::ASCII, '', GWF_User::EMAIL_LENGTH),
			'prof_skype' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 63),
			'prof_yahoo' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 63),
			'prof_aim' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 63),
			'prof_irc' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 255),
		);
	}
	
	##################
	### Convinient ###
	##################
	public function isHidden(GWF_User $user) { return $this->isHiddenLevel($user->getLevel()); }
	public function isContactHidden(GWF_User $user) { return $this->isContactHiddenLevel($user->getLevel()); }
	public function isEMailHidden() { return $this->isOptionEnabled(self::HIDE_EMAIL); }
	public function isCountryHidden() { return $this->isOptionEnabled(self::HIDE_COUNTRY);}
//	public function isBirthdayHidden() { return !$this->isOptionEnabled(self::SHOW_BIRTHDAY); }
	public function displayAboutMe() { return GWF_Message::display($this->getVar('prof_about_me')); }
	public function isGuestHidden() { return $this->isOptionEnabled(self::HIDE_GUESTS); }
	public function isRobotHidden() { return $this->isOptionEnabled(self::HIDE_ROBOTS); }
	public function isHiddenLevel($level) { return $level < $this->getVar('prof_level_all'); }
	public function isContactHiddenLevel($level) { return $level < $this->getVar('prof_level_contact'); }
	
	###############
	### Display ###
	###############
	
	#####################
	### Static Getter ###
	#####################
	/**
	 * Get the profile row for a user.
	 * Create a new in case none exists.
	 * @param int $userid
	 * @return GWF_Profile
	 */
	public static function getProfile($userid)
	{
		if (false === ($row = self::table(__CLASS__)->getRow($userid))) {
			return self::createProfile($userid);
		}
		else {
			return $row;
		}
	}
	
	/**
	 * Create a clean profile.
	 * @param int $userid
	 * @return GWF_Profile
	 */
	private static function createProfile($userid)
	{
		$profile = new self(array(
			'prof_uid' => $userid,
			'prof_views' => 0,
			'prof_about_me' => '',
			'prof_options' => 0,
			'prof_website' => '',
			'prof_level_all' => 0, 'prof_level_contact' => 0,
			'prof_firstname' => '', 'prof_lastname' => '',
			'prof_street' => '', 'prof_zip' => '', 'prof_city' => '',
			'prof_tel' => '', 'prof_mobile' => '',
			'prof_icq' => '', 'prof_msn' => '', 'prof_jabber' => '', 'prof_skype' => '', 'prof_yahoo' => '', 'prof_aim' => '',
			'prof_irc' => '',
		));
		if (false === $profile->replace()) {
			return false;
		}
		return $profile;
	}
}

?>