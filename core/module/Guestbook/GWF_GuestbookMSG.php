<?php
/**
 * A guestbook entry.
 * @author gizmore
 * @version 1.0
 */
final class GWF_GuestbookMSG extends GDO
{
	###############
	### Options ###
	###############
	const SHOW_PUBLIC = 0x01;
	const IN_MODERATION = 0x02;
	const ALLOW_PUBLIC_TOGGLE = 0x04;
	const SHOW_EMAIL = 0x08;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'guestbook_entry'; }
	public function getOptionsName() { return 'gbm_options'; }
	public function getColumnDefines()
	{
		return array(
			'gbm_id' => array(GDO::AUTO_INCREMENT),
			'gbm_gbid' => array(GDO::UINT|GDO::INDEX, 0),
			'gbm_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'gbm_uid' => array(GDO::UINT, 0),
			'gbm_url' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'gbm_email' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'gbm_options' => array(GDO::UINT, 0),
			'gbm_username' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 63),
			'gbm_message' => array(GDO::MESSAGE),
			'gbm_replyto' => array(GDO::UINT|GDO::INDEX, 0),
		);
	}
	
	##################
	### Convinient ###
	##################
	public function getEMailHREF() { return 'mailto:'.$this->getVar('gbm_email'); }
	public function isPublicShown() { return $this->isOptionEnabled(self::SHOW_PUBLIC); }
	public function isInModeration() { return $this->isOptionEnabled(self::IN_MODERATION); }
	public function isToggleAllowed() { return $this->isOptionEnabled(self::ALLOW_PUBLIC_TOGGLE); }
	
//	public function isAdminMessage()
//	{
//		if ('0' === ($userid = $this->getVar('gbm_uid'))) {
//			return false;
//		}
//		return GWF_UserGroup::isInGroupName($userid, GWF_Group::ADMIN);
//	}

	public function mayEdit($user)
	{
		if ($user === false) {
			return false;
		}
		if ($user->isAdmin()) {
			return true;
		}
		if ($user->getID() === $this->getVar('gbm_uid')) {
			return true;
		}
		return false;
	}
	
	#####################
	### Static Getter ###
	#####################
	/**
	 * @param int $id
	 * @return GWF_GuestbookMSG
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}
	
	###############
	### Display ###
	###############
	public function displayDate() { return GWF_Time::displayDate($this->getVar('gbm_date')); }
	public function displayUsername() { return $this->display('gbm_username'); }
	public function displayEMail($can_mod)
	{
		if ($this->isOptionEnabled(self::SHOW_EMAIL) || $can_mod)
		{
			$email = $this->display('gbm_email');
			if ($email === '') {
				return '';
			} else {
				return GWF_HTML::anchor($this->getEMailHREF(), $email);
			}
		}
		else
		{
			return ''; 
		}
		
	}
	public function displayURL() { $url = $this->getVar('gbm_url'); return GWF_HTML::anchor($url, $url); }
	public function displayMessage() { return GWF_Message::display($this->getVar('gbm_message')); }
	public function isGuestMessage() { return $this->getVar('gbm_uid') === '0'; }
	public function displayUsernameLink() { $uname = $this->displayUsername(); return $this->isGuestMessage() ? $uname : GWF_HTML::anchor(GWF_WEB_ROOT.'profile/'.$uname, $uname); }
	
	###################
	### Mod Buttons ###
	###################
	/**
	 * Get toggle moderation button / toggle visibility button.
	 * @param $module
	 * @return unknown_type
	 */
	public function getToggleModButton(Module_Guestbook $module)
	{
		if ($this->isInModeration()) {
			return GWF_Button::add($module->lang('btn_moderate_no'), $this->getModHref(false));
		} else {
			return GWF_Button::sub($module->lang('btn_moderate_yes'), $this->getModHref(true));
		}
	}
	
	private function getModHref($on)
	{
		return GWF_WEB_ROOT.'index.php?mo=Guestbook&me=Moderate&gbid='.$this->getVar('gbm_gbid').'&gbmid='.$this->getVar('gbm_id').'&set_moderation='.($on?'1':'0');
	}
	
	public function getTogglePublicButton(Module_Guestbook $module)
	{
		if (!$this->isToggleAllowed()) {
			return '';
		}
		if ($this->isPublicShown()) {
			return GWF_Button::ignore($this->getToggleHref(false), $module->lang('btn_public_hide'));
		} else {
			return GWF_Button::forward($this->getToggleHref(true), $module->lang('btn_public_show'));
		}
	}
	private function getToggleHref($on)
	{
		return GWF_WEB_ROOT.'index.php?mo=Guestbook&me=Moderate&gbid='.$this->getVar('gbm_gbid').'&gbmid='.$this->getVar('gbm_id').'&set_public='.($on?'1':'0');
	}
	
	public function getEditButton(Module_Guestbook $module)
	{
		return GWF_Button::edit($this->getEditHref(), $module->lang('btn_edit_entry'));
	}
	private function getEditHref()
	{
		return GWF_WEB_ROOT.'index.php?mo=Guestbook&me=Moderate&gbid='.$this->getVar('gbm_gbid').'&gbmid='.$this->getVar('gbm_id').'&edit_entry=yes';
	}
	
}

?>
