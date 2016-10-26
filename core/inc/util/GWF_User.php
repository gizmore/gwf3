<?php
/**
 * The user is holy and not just a profile!
 * @author gizmore
 * @see GWF_Session
 * @see Module_Account
 * @see Module_Usergroups
 * @version 3.0
 * @since 1.0
 */
final class GWF_User extends GDO
{
	### Option Bits ###
	const BOT = 0x01;
	const DELETED = 0x02;
	const HAS_AVATAR = 0x04;
	const WANTS_ADULT = 0x08;
	const MAIL_APPROVED = 0x10;
	const HIDE_ONLINE = 0x20;
	const SHOW_EMAIL = 0x40;
	const IS_GUEST = 0x80;
	const IS_SEARCH_ENGINE = 0x100;
	const ALLOW_EMAIL = 0x200;
	const SHOW_BIRTHDAY = 0x400;
	const SHOW_OTHER_BIRTHDAYS = 0x800;
	const EMAIL_HTML = 0x0000;
	const EMAIL_TEXT = 0x1000;
	const EMAIL_GPG = 0x2000;
	const WEBSPIDER = 0x4000;
	const RESERVED1 = 0x8000;
	const RECORD_IPS = 0x10000;
	const ALERT_IPS = 0x20000;
	const ALERT_ISPS = 0x40000;
	const ALERT_UAS = 0x80000;
	
	### Gender Bits ###
	const MALE = 'male';
	const FEMALE = 'female';
	const NO_GENDER = 'no_gender';

	### Constants
	const EMAIL_LENGTH = 255;
	const USERNAME_LENGTH = 32;

	###########
	### GDO ###
	###########
	public function getTableName() { return GWF_TABLE_PREFIX.'user'; }
	public function getClassName() { return __CLASS__; }
	public function getOptionsName() { return 'user_options'; }
	public function getColumnDefines()
	{
		return array(
			'user_id' => array(GDO::AUTO_INCREMENT),
			'user_options' => array(GDO::UINT|GDO::INDEX, 0),
			'user_name' => array(GDO::VARCHAR|GDO::UNIQUE|GDO::ASCII|GDO::CASE_I, GDO::NOT_NULL, self::USERNAME_LENGTH),
			'user_password' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 44),
			'user_regdate' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'user_regip' => GWF_IP6::gdoDefine(GWF_IP_EXACT, GDO::NOT_NULL),
			'user_email' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, '', 255),
			'user_gender' => array(GDO::ENUM, 'no_gender', array('male', 'female', 'no_gender')),
			'user_lastlogin' => array(GDO::UINT, 0),
			'user_lastactivity' => array(GDO::UINT|GDO::INDEX, 0),
			'user_birthdate' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, '00000000', GWF_Date::LEN_DAY),
			'user_avatar_v' => array(GDO::UINT, 0),
			'user_countryid' => array(GDO::UINT|GDO::INDEX, 0, 11),
			'user_langid' => array(GDO::UINT, 0, 11),
			'user_langid2' => array(GDO::UINT, 0, 11),
			'user_level' => array(GDO::INT|GDO::INDEX, 0),
			'user_title' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, '', 63),
			'user_settings' => array(GDO::BLOB),
			'user_data' => array(GDO::BLOB),
			'user_credits' => array(GDO::DECIMAL, '0.00', array(9, 4)),
		);
	}
	public function getID() { return $this->getVar('user_id'); }
	public function getGender() { return $this->getVar('user_gender'); }
	public function hasAvatar() { return $this->isOptionEnabled(self::HAS_AVATAR); }
	public function hasCountry() { return $this->getVar('user_countryid') !== '0'; }

	/**
	 * Get a user by ID.
	 * @param int $userid
	 * @return GWF_User
	 */
	public static function getByID($id) { return self::table(__CLASS__)->selectFirstObject('*', 'user_id=\''.self::escape($id).'\''); }

	/**
	 * Get a user by name.
	 * @param string $username
	 * @return GWF_User
	 */
	public static function getByName($name) { return self::table(__CLASS__)->selectFirstObject('*', 'user_name=\''.self::escape($name).'\''); }

	/**
	 * Get a user by EMail.
	 * @param string $email
	 * @return GWF_User
	 */
	public static function getByEmail($email) { return self::table(__CLASS__)->selectFirstObject('*', 'user_email=\''.self::escape($email).'\''); }
	
	/**
	 * Get all users inside a group.
	 * FIXME: This returns not an array of GWF_User!!!!
	 * @param string $groupname
	 * @return array
	 */
	public static function getAllInGroup($groupname) { return GWF_UserSelect::getUsers($groupname); }

	############
	### Lang ###
	############

	/**
	 * @return GWF_Language
	 */
	public function getLanguage() { return GWF_Language::getByID($this->getVar('user_langid')); }

	/**
	 * @return GWF_Language
	 */
	public function getSecLanguage() { return GWF_Language::getByID($this->getVar('user_langid2')); }

	public function getLangID() { return $this->getVar('user_langid'); }

	###############
	### Country ###
	###############
	public function getCountryID() { return $this->getVar('user_countryid'); }
	public function displayCountryFlag($unknown=true)
	{
		if ( ('0' === ($cid = $this->getCountryID())) && ($unknown === false) ) {
			return '';
		}
		return GWF_Country::displayFlagS($cid);
	}

	###############
	### Profile ###
	###############
	public function getProfileHREF() { return GWF_WEB_ROOT.'profile/'.$this->urlencode('user_name'); }
	public function displayUsername() { return $this->display('user_name'); }
	public function getGenderSelect($name='gender') { return GWF_Gender::select($name, Common::getPostString($name, $this->getVar('user_gender'))); }
	public function getCountrySelect($name='country') { return GWF_CountrySelect::single($name, Common::getPostString($name, $this->getCountryID())); }
	public function displayProfileLink()
	{
		return self::displayProfileLinkS($this->getVar('user_name'));
//		return GWF_HTML::anchor($this->getProfileHREF(), $this->getVar('user_name'));
	}
	public function displayProfileLink2()
	{
		return true === $this->isGuest()
			? $this->displayUsername()
			: self::displayProfileLinkS($this->getVar('user_name'));
	}
	public static function displayProfileLinkS($username)
	{
		return sprintf('<a href="%sprofile/%s">%s</a>', GWF_WEB_ROOT, urlencode($username), htmlspecialchars($username));
	}
	public function displayAvatar()
	{
		if (!$this->isOptionEnabled(self::HAS_AVATAR)) {
			return '';
		}
		$alt = GWF_HTML::lang('alt_avatar', array($this->displayUsername()));
		$src = $this->getAvatarURL();
		return sprintf('<img src="%s" alt="%s" title="%s" />', $src, $alt, $alt);
	}
	public function displayTitle() { return $this->display('user_title'); }
	public function isOnline() { return $this->isOptionEnabled(self::HIDE_ONLINE) ? false : ($this->getVar('user_lastactivity') + GWF_ONLINE_TIMEOUT) >= time(); }
	public function getPMHREF() { return sprintf('%spm/send/to/%s', GWF_WEB_ROOT, $this->urlencode('user_name')); }
	public function getAvatarURL() { return sprintf('%sdbimg/avatar/%d?v=%d', GWF_WEB_ROOT, $this->getID(), $this->getVar('user_avatar_v')); }
	public function getAvatarFilename() { return sprintf('%sdbimg/avatar/%d', GWF_WWW_PATH, $this->getID());
	}
	
	public function displayEMail()
	{
		return self::displayEMailS($this->getVar('user_email'));
	}

	public static function displayEMailS($email)
	{
		switch(rand(1,6))
		{
			case 1: $r = array('[at]', ' dot '); break;
			case 2: $r = array('[at]', 'dot'); break;
			case 3: $r = array('at ', '[dot]'); break;
			case 4: $r = array(' at ', 'dot'); break;
			case 5: $r = array(' at', ' dot '); break;
			case 6: $r = array(' at ', '[dot]'); break;
		}
		return htmlspecialchars(str_replace(array('@', '.'), $r, $email));
	}

	###################
	### Permissions ###
	###################
	private $groups = true;
	public static function isLoggedIn() { return GWF_Session::getUserID() !== '0'; }
	public static function getByIDOrGuest($id) { return (false === ($u = self::getByID($id))) ? GWF_Guest::getGuest() : $u; }
	public static function getStaticOrGuest() { return (false === ($user = GWF_Session::getUser())) ? GWF_Guest::getGuest() : $user; }
	public static function isAdminS() { return self::getStaticOrGuest()->isAdmin(); }
	public function isAdmin() { return $this->isInGroupName(GWF_Group::ADMIN); }
	public static function isStaffS() { return self::getStaticOrGuest()->isStaff(); }
	public function isStaff() { return $this->isInGroupName(GWF_Group::STAFF); }
	public function isBot() { return $this->isOptionEnabled(self::BOT); }
	public function isGuest() { return $this->getID() === '0'; }
	public function isWebspider() { return $this->isOptionEnabled(self::WEBSPIDER); }
	public function isDeleted() { return $this->isOptionEnabled(self::DELETED); }
	public function isUser() { return false === ($this->isGuest() || $this->isBot() || $this->isWebspider() || $this->isDeleted()); }
	public function getLevel() { return $this->getVar('user_level'); }
	public function hasValidMail() { return $this->isOptionEnabled(self::MAIL_APPROVED); }
	public function getValidMail() { return $this->hasValidMail() ? $this->getVar('user_email') : ''; }

	#########################
	### Group Permissions ###
	#########################
	public static function isInGroupS($groupname) { return self::getStaticOrGuest()->isInGroupName($groupname); }
	public function isInGroupName($groupname) { $this->loadGroups(); return isset($this->groups[$groupname]); }
	public function loadGroups()
	{
		if ($this->groups === true)
		{ 
			$this->groups = GDO::table('GWF_UserGroup')->selectArrayMap(
				'group_name, t.*, group_founder, group_id, group_options', 'ug_userid='.$this->getID(), '', array('group'), self::ARRAY_O, -1, -1, 'group_name'
			);
		}
		return $this->groups;
	}
	public function getGroups() { return $this->loadGroups(); }
	public function isInGroupID($gid) { return $gid === '0' ? true : $this->getGroupByID($gid) !== false; }
	public function getGroupByName($groupname) { return isset($this->groups[$groupname]) ? $this->groups[$groupname] : false; }
	public function getGroupByID($gid)
	{
		if ($gid !== '0')
		{
			foreach ($this->loadGroups() as $name => $ug)
			{
				if ($ug->getVar('ug_groupid') === $gid)
				{
					return $ug;
				}
			}
		}
		return false;
	}
	public function getUserGroupOptions($gid)
	{
		if (false === ($group = $this->getGroupByID($gid)))
		{
			return 0;
		}
		return $group->getInt('ug_options');
	}

	###################
	### Option BLOB ###
	###################
	/**
	 * Return the serialized userdata blob. An associative array.
	 * @return array
	 */
	public function getUserData()
	{
		$data = $this->getVar('user_data');
		if ($data === '') {
			$this->setVar('user_data', serialize(array()));
			return array();
		}
		return unserialize($data);
	}

	public function saveUserData(array $userdata)
	{
		$this->setVar('user_data', $userdata);
		return $this->saveVar('user_data', serialize($userdata));
	}
}

