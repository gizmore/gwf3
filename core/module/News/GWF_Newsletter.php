<?php
/**
 * userid => newsletter table.
 * @author gizmore
 * @version 1.0
 */
final class GWF_Newsletter extends GDO
{
	const WANT_HTML = 0x01;
	const WANT_TEXT = 0x02;
	const TYPE_FIELDS = 0x03;
	const WANT_REMINDER = 0x04;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'newsletter'; }
	public function getOptionsName() { return 'nl_options'; }
	public function getColumnDefines()
	{
		return array(
			'nl_email' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, true, GWF_User::EMAIL_LENGTH),
			'nl_userid' => array(GDO::INDEX|GDO::UINT, 0),
			'nl_options' => array(GDO::UINT, self::WANT_TEXT),
			'nl_unsign' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, true, 16),
			'nl_langid' => array(GDO::INDEX|GDO::UINT, true),
			'nl_mailed_ids' => array(GDO::BLOB),
		);
	}
	public function getEMail() { return $this->getVar('nl_email'); }
	public function getToken() { return $this->getVar('nl_unsign'); }
	public function getOptions() { return (int) $this->getVar('nl_options'); }
	public function isHTML() { return $this->getType() === self::WANT_HTML; }
	public function getLangID() { return $this->getInt('nl_langid'); }
	
	public function getType()
	{
		$mask = $this->getOptions() & self::TYPE_FIELDS;
		switch ($mask)
		{
			case self::WANT_HTML:
			case self::WANT_TEXT: return $mask;
			default: return 0;
		}
	}
	
	/**
	 * @return GWF_User
	 */
	public function getUser()
	{
		return GWF_User::getByID($this->getVar('nl_userid'));
	}
	
	public function getUsername()
	{
		if (false === ($user = $this->getUser())) {
			return $this->getEMail();
		}
		else {
			return $user->getVar('user_name');
		}
	}
	
	public function hasBeenMailed($newsid)
	{
		return strpos($this->getVar('nl_mailed_ids'), ':'.intval($newsid).':') !== false;
	}
	
	public function setBeenMailed($newsid)
	{
		return $this->saveVar('nl_mailed_ids', $this->getVar('nl_mailed_ids').intval($newsid).':');
	}
	
	### 
/*	public function getNewsletterRow($user)
	{
		if (false === ($nl = self::table(__CLASS__)->getRow($user))) {
			return self::createNewsletterRow($userid);
		}
		return $nl;
	}
	
	public function createNewsletterRow($userid)
	{
		$nl = new self(array(
			'nl_email' => $email,
			'nl_userid' => 0,
			'nl_options' => self::TYPE_FIELDS,
			'nl_unsign' => 'B4Dc0d3dCh42z',
			'nl_langid' => GWF_Language::getCurrentID(),
		));
	}*/
	
	###############
	### Preview ###
	###############
	public static function getPreviewRow($email)
	{
		return new self(array(
			'nl_email' => $email,
			'nl_userid' => 0,
			'nl_options' => self::TYPE_FIELDS,
			'nl_unsign' => 'B4Dc0d3dCh42z',
			'nl_langid' => GWF_Language::getCurrentID(),
		));
	}

	##################
	### Validation ###
	##################
	public function validate_email(Module_News $module, $email) { return GWF_Validator::validateEMail($module, 'email', $email, true, false); }
	
	public function validate_type(Module_News $module, $type)
	{
		switch ((int) $type)
		{
			case self::WANT_HTML:
			case self::WANT_TEXT: 
				return false;
			case 0:
			default: 
				return $module->lang('err_type');
		}
	}
	
	public function validate_langid(Module_News $module, $langid)
	{
		return GWF_Language::isSupported($langid) ? false : $module->lang('err_langtrans');
	}
	
	public function saveType($type)
	{
		$opt = $this->getOptions();
		
		$opt = $opt & (~self::TYPE_FIELDS);
		
		$opt |= $type;
		
		return $this->saveVar('nl_options', $opt);
	}
	
	public function getEmailType()
	{
		return $this->isOptionEnabled(self::WANT_HTML) ? self::WANT_HTML : self::WANT_TEXT;
	}
	
	public static function getEmailTypeForUser($user)
	{
		if (false === ($row = self::getRowForUser($user))) {
			return 0;
		}
		return $row->getEmailType();
	}
	
	/**
	 * @param $user
	 * @return GWF_Newsletter
	 */
	public static function getRowForUser($user)
	{
		if ($user === false)
		{
			return false;
		}
		$user instanceof GWF_User;
		if ('' === ($email = $user->getValidMail()))
		{
			return false;
		}
		return self::table(__CLASS__)->getBy('nl_userid', $user->getID());
	}
	
	public static function userWantsNewsletter(GWF_User $user)
	{
		return self::getEmailTypeForUser($user) !== 0;
	}
	
	/**
	 * @param $html boolean html or text (html=true, text=false)
	 * @param $langid the language of the newsletter.
	 * @return unknown_type
	 */
	public static function getNewsletterEmails($html=true, $langid)
	{
		$newsletters = new self(false);
		$flag = $html === true ? self::WANT_HTML : self::WANT_TEXT;
		return $newsletters->selectObjects('*', "nl_options&$flag");
	}
	
	public static function getTypeSelect(Module_News $module, $key)
	{
		if (false === ($user = GWF_Session::getUser())) {
			$email = Common::getPost('email', '');
		}
		else {
			$email = $user->getValidMail();
		}
		
		$newsletter = new self(false);
		if (false === ($nl = $newsletter->getRow($email))) {
			$type = Common::getPost('type');
		}
		else {
			$type = $nl->getEmailType();
		}
		
		return self::getTypeSelectB($module, $key, $type);
	}
	
	public static function getTypeSelectB(Module_News $module, $key, $value=0)
	{
		$key = GWF_HTML::display($key);
		$value = (int) $value;
		
		$back = sprintf('<select name="%s">'.PHP_EOL, $key);
		
		$sel = GWF_HTML::selected($value === 0);
		$back .= sprintf('<option value="%d"%s>%s</option>'.PHP_EOL, 0, $sel, $module->lang('type_none'));
		
		$sel = GWF_HTML::selected($value === self::WANT_TEXT);
		$back .= sprintf('<option value="%d"%s>%s</option>'.PHP_EOL, self::WANT_TEXT, $sel, $module->lang('type_text'));
		
		$sel = GWF_HTML::selected($value === self::WANT_HTML);
		$back .= sprintf('<option value="%d"%s>%s</option>'.PHP_EOL, self::WANT_HTML, $sel, $module->lang('type_html'));
		
		$back .= '</select>'.PHP_EOL;
		
		return $back;
	}
	
	##################
	### Convinient ###
	##################
	public static function getByEmail($email)
	{
		$nl = new self(false);
		return $nl->getRow($email);
	}
	
	#####################
	### Unsign Anchor ###
	#####################
	public function getUnsignAnchor()
	{
		$href = $this->getUnsignHREF();
		$href = Common::getAbsoluteURL($href, false);
		return GWF_HTML::anchor($href, $href);
	}
	
	public function getUnsignHREF()
	{
		return GWF_WEB_ROOT.sprintf('newsletter/unsubscribe/%s/%s', $this->getEmail(), $this->getToken());
	}
	
}

?>