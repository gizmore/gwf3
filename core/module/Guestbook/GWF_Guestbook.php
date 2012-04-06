<?php
/**
 * A Guestbook.
 * Mutliple guestbooks are possible.
 * @author gizmore
 */
final class GWF_Guestbook extends GDO
{
	###############
	### Options ###
	###############
	const DEFAULT_OPTIONS = 0xFC; # All but not LOCKED and not MODERATED
	const LOCKED = 0x01;
	const MODERATED = 0x02;
	const ALLOW_GUEST_VIEW = 0x04;
	const ALLOW_GUEST_SIGN = 0x08;
	const ALLOW_BBCODE = 0x10;
	const ALLOW_WEBSITE = 0x20;
	const ALLOW_SMILEY = 0x40;
	const ALLOW_EMAIL = 0x80;
	const ALLOW_NESTING = 0x100;
	const EMAIL_ON_ENTRY = 0x200;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'guestbook'; }
	public function getOptionsName() { return 'gb_options'; }
	public function getColumnDefines()
	{
		return array(
			'gb_id' => array(GDO::AUTO_INCREMENT),
			'gb_uid' => array(GDO::UINT|GDO::INDEX, 0),
			'gb_title' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 63),
			'gb_descr' => array(GDO::MESSAGE|GDO::UTF8|GDO::CASE_I),
			'gb_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'gb_options' => array(GDO::UINT, 0),
		);
	}
	
	##################
	### Convinient ###
	##################
	public function isLocked() { return $this->isOptionEnabled(self::LOCKED); }
	public function isModerated() { return $this->isOptionEnabled(self::MODERATED); }
	public function isGuestViewable() { return $this->isOptionEnabled(self::ALLOW_GUEST_VIEW); }
	public function isGuestWriteable() { return $this->isOptionEnabled(self::ALLOW_GUEST_SIGN); }
	public function isURLAllowed() { return $this->isOptionEnabled(self::ALLOW_WEBSITE); }
	public function isEMailAllowed() { return $this->isOptionEnabled(self::ALLOW_EMAIL); }
	public function isEMailOnSign() { return $this->isOptionEnabled(self::EMAIL_ON_ENTRY); }
	public function isBBAllowed() { return $this->isOptionEnabled(self::ALLOW_BBCODE); }
	public function isSmileyAllowed() { return $this->isOptionEnabled(self::ALLOW_SMILEY); }
	public function isNestingAllowed() { return $this->isOptionEnabled(self::ALLOW_NESTING); }
	public function getUserID() { return $this->getVar('gb_uid'); }
	/**
	 * @return GWF_User
	 */
	public function getUser() { return GWF_User::getByID($this->getUserID()); }
	
	###############
	### Display ###
	###############
	public function displayTitle() { return $this->display('gb_title'); }
	public function displayDescr() { return $this->display('gb_descr'); }
	
	#############
	### HREFs ###
	#############
	public function hrefEdit()
	{
		return GWF_WEB_ROOT.'guestbook/edit/'.$this->getID();
	}
	
	#####################
	### Static Getter ###
	#####################
	/**
	 * @param int $id
	 * @return GWF_Guestbook
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}
	
	/**
	 * @param int $id
	 * @return GWF_Guestbook
	 */
	public static function getByUID($userid)
	{
		return self::table(__CLASS__)->getBy('gb_uid', $userid);
	}
	
	##################
	### Permission ###
	##################
	public function canModerate($user)
	{
		if ($user === false) {
			return false;
		}
		
		if ($user->isAdmin()) {
			return true;
		}
		
		if ($user->getID() === $this->getVar('gb_uid')) {
			return true;
		}
		
		return false;
	}
	
	public function canView($user)
	{
		if ($user !== false) {
			return true;
		}
		else {
			return $this->isGuestViewable();
		}
	}
	
	public function canSign($user, $allow_guest)
	{
		if ($this->isLocked()) {
			return false;
		}
		if ($user === false) {
			return $allow_guest && $this->isGuestWriteable();
		}
		return true;
	}
}

?>
