<?php
/**
 * Change account settings
 * @author gizmore
 */
final class Account_Form extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^account/?$ index.php?mo=Account&me=Form'.PHP_EOL;
	}
	
	public function getPageMenuLinks()
	{
		return array(
			array(
				'page_url' => 'account',
				'page_title' => 'Account',
				'page_meta_desc' => 'Your account',
			),
		);
	}
	
	public function execute()
	{
		if (isset($_POST['delete'])) {
			die(GWF_Website::redirect($this->module->getMethodURL('Delete')));
		}
		if (false !== (Common::getPost('drop_avatar'))) {
			return $this->onDeleteAvatar().$this->templateForm();
		}
		if (false !== (Common::getPost('change'))) {
			return $this->onChange().$this->templateForm();
		}
		if (false !== Common::getPost('approvemail')) {
			return $this->onApproveMail().$this->templateForm();
		}
		if (false !== Common::getPost('setup_gpg')) {
			return $this->onSetupGPG().$this->templateForm();
		}
		if (false !== Common::getPost('remove_gpg')) {
			return $this->onRemoveGPG().$this->templateForm();
		}
		return $this->templateForm();
	}
	
	private function templateForm()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('form_title')),
		);
		
		if (function_exists('gnupg_init'))
		{
			$formGPG = $this->getFormGPG();
			$tVars['form_gpg'] = $formGPG->templateY($this->module->lang('ft_gpg'));
		}
		else
		{
			$tVars['form_gpg'] = '';
		}
		
		return $this->module->template('form.tpl', $tVars);
	}
	
	################
	### The Form ###
	################
	public function getForm()
	{
		$user = GWF_Session::getUser();
		$user_email = $user->getVar('user_email');
		
		# SECURITY
		$data = array(
			'username' => array(GWF_Form::SSTRING, $user->getVar('user_name'), $this->module->lang('th_username')),
			'email' => array(GWF_Form::STRING, $user_email, $this->module->lang('th_email')),
		);
		
		### Email set but not approved.
		if ($user_email !== '' && !$user->hasValidMail()) {
			$data['approvemail'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_approvemail'), $this->module->lang('th_approvemail'));
		}
		
		// DEMOGRAPHICS
		$data['div1'] = array(GWF_Form::HEADLINE, $this->module->lang('th_demo', array(GWF_Time::humanDuration($this->module->cfgChangeTime()), 1)));
		$data['countryid'] = array(GWF_Form::SELECT, $user->getCountrySelect('countryid'), $this->module->lang('th_countryid'));
		$data['langid'] = array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'langid', Common::getPostString('langid', $user->getVar('user_langid'))), $this->module->lang('th_langid'));
		$data['langid2'] = array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'langid2', Common::getPostString('langid2', $user->getVar('user_langid2'))), $this->module->lang('th_langid2'));
		$data['birthdate'] = array(GWF_Form::DATE, $user->getVar('user_birthdate'), $this->module->lang('th_birthdate'), '', GWF_Date::LEN_DAY);
		if ($this->module->cfgShowGender())
		{
			$data['gender'] = array(GWF_Form::SELECT, $user->getGenderSelect(), $this->module->lang('th_gender'));
		}
		// OPTIONS
		$data['div2'] = array(GWF_Form::HEADLINE, $this->module->lang('th_flags'));
		
		$data['email_fmt'] = array(GWF_Form::SELECT, $this->selectEMailFormat($user), $this->module->lang('th_email_fmt'));
		
		if ($this->module->cfgShowCheckboxes())
		{
			$data['online'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::HIDE_ONLINE), $this->module->lang('th_online'));
			$data['record_ips'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::RECORD_IPS), $this->module->lang('th_record_ips', array($this->module->getMethodURL('Access'))), $this->module->lang('tt_record_ips'));
			$data['alert_uas'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::ALERT_UAS), $this->module->lang('th_alert_uas'), $this->module->lang('tt_alert_uas'));
			$data['alert_ips'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::ALERT_IPS), $this->module->lang('th_alert_ips'), $this->module->lang('tt_alert_ips'));
			$data['alert_isps'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::ALERT_ISPS), $this->module->lang('th_alert_isps'), $this->module->lang('tt_alert_isps'));
			$data['show_bday'] = array(GWF_Form::CHECKBOX,  $user->isOptionEnabled(GWF_User::SHOW_BIRTHDAY), $this->module->lang('th_show_bday'));
			$data['show_obday'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::SHOW_OTHER_BIRTHDAYS), $this->module->lang('th_show_obday'));
			$data['show_email'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::SHOW_EMAIL), $this->module->lang('th_show_email'));
			$data['allow_email'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::ALLOW_EMAIL), $this->module->lang('th_allow_email'));
		}
		
		
		if ($this->module->cfgShowAdult())
		{
			if (GWF_Time::getAge($user->getVar('user_birthdate')) >= $this->module->cfgAdultAge()) {
				$data['adult'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::WANTS_ADULT), $this->module->lang('th_adult'));
			}
		}
				
		if ($this->module->cfgUseAvatar())
		{
			// Avatar
			if ($user->isOptionEnabled(GWF_User::HAS_AVATAR))
			{
				$data['avatar'] = array(GWF_Form::HEADLINE, $user->displayAvatar(), $this->module->lang('th_avatar'));
				$data['drop_avatar'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_drop_avatar'), '');
			}
			else
			{
				$data['avatar'] = array(GWF_Form::FILE_OPT, '', $this->module->lang('th_avatar'));
			}
		}
		
		$data['divpw'] = array(GWF_Form::HEADLINE, $this->module->lang('th_change_pw', array( 'recovery')));
		
		// BTN
		$buttons = array('change'=>$this->module->lang('btn_submit'),'delete'=>$this->module->lang('btn_delete'));
//		$data['change'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_submit'), '');
		$data['buttons'] = array(GWF_Form::SUBMITS, $buttons);		
		return new GWF_Form($this, $data);
	}

	#######################
	### Change Settings ###
	#######################
	private function selectEMailFormat(GWF_User $user)
	{
		$data = array(
			array(GWF_User::EMAIL_HTML, $this->module->lang('email_fmt_html')),
			array(GWF_User::EMAIL_TEXT, $this->module->lang('email_fmt_text')),
		);
		$selected = $user->isOptionEnabled(GWF_User::EMAIL_TEXT) ? GWF_User::EMAIL_TEXT : 0;
		return GWF_Select::display('email_fmt', $data, $selected);
	}
	
	private function onChange()
	{
		$back = '';
		$user = GWF_Session::getUser();
		$form = $this->getForm();
		if (false !== ($errors = $form->validate($this->module))) {
			return $errors;
		}
		
		# Upload Avatar
		if (false !== ($file = $form->getVar('avatar'))) {
			$back .= $this->saveAvatar($file);
			Common::unlink($file['tmp_name']);
		}

		
		# Flags
		if ($this->module->cfgShowAdult() && GWF_Time::getAge($user->getVar('user_birthdate')) > $this->module->cfgAdultAge()) {
			$back .= $this->changeFlag($user, 'adult', GWF_USER::WANTS_ADULT);
		}
		$back .= $this->changeFlag($user, 'online', GWF_USER::HIDE_ONLINE);
		$back .= $this->changeFlag($user, 'show_bday', GWF_USER::SHOW_BIRTHDAY);
		$back .= $this->changeFlag($user, 'show_obday', GWF_USER::SHOW_OTHER_BIRTHDAYS);
		$back .= $this->changeFlag($user, 'show_email', GWF_USER::SHOW_EMAIL);
		$back .= $this->changeFlag($user, 'allow_email', GWF_USER::ALLOW_EMAIL);
		# Flags IP recording
		$msg_record_disabled = $this->changeFlag($user, 'record_ips', GWF_USER::RECORD_IPS);
		if ($msg_record_disabled !== '')
		{
			$back .= $msg_record_disabled;
			if (!$user->isOptionEnabled(GWF_User::RECORD_IPS))
			{
				GWF_AccountAccess::sendAlertMail($this->module, $user, 'record_disabled');
				unset($_POST['alert_uas'], $_POST['alert_ips'], $_POST['alert_isps']);
			}
		}
		$back .= $this->changeFlag($user, 'alert_uas', GWF_USER::ALERT_UAS);
		$back .= $this->changeFlag($user, 'alert_ips', GWF_USER::ALERT_IPS);
		$back .= $this->changeFlag($user, 'alert_isps', GWF_USER::ALERT_ISPS);
		
		
		# Email Format
		$newfmt = (int) $_POST['email_fmt'];
		$oldfmt = $user->isOptionEnabled(GWF_User::EMAIL_TEXT) ? GWF_User::EMAIL_TEXT : 0;
		if ($newfmt !== $oldfmt) {
			$user->saveOption(GWF_User::EMAIL_TEXT, $newfmt > 0);
			$back .= $this->module->message('msg_email_fmt_'.$newfmt);
		}
		
		# Change EMAIL
		$newmail =$form->getVar('email');
		$oldmail = $user->getVar('user_email');
		if ($newmail !== $oldmail) {
			require_once 'ChangeEmail.php';
			$back .= Account_ChangeEmail::changeEmail($this->module, $user, $newmail);
		}
		
		
		# Change Demo
		$demo_changed = false;

		$oldcid = (int) $user->getVar('user_countryid');
		$newcid = (int) $form->getVar('countryid');
		if ($oldcid !== $newcid) { $demo_changed = true; }
		$oldlid = (int) $user->getVar('user_langid');
		$newlid = (int) $form->getVar('langid');
		if ($oldlid !== $newlid) { $demo_changed = true; }
		$oldlid2 = (int) $user->getVar('user_langid2');
		$newlid2 = (int) $form->getVar('langid2');
		if ($oldlid2 !== $newlid2) { $demo_changed = true; }
		$oldgender = $user->getVar('user_gender');
		$newgender = $form->getVar('gender', GWF_User::NO_GENDER);
		if ($oldgender !== $newgender) { $demo_changed = true; }
		$oldbirthdate = $user->getVar('user_birthdate');
		$newbirthdate = $form->getVar('birthdate');
		if ($newbirthdate === '') { $newbirthdate = '00000000'; }
		if ($oldbirthdate != $newbirthdate) { $demo_changed = true; }
		
		if ($demo_changed)
		{
			$data = array(
				'user_countryid' => $newcid,
				'user_langid' => $newlid,
				'user_langid2' => $newlid2,
				'user_gender' => $newgender,
				'user_birthdate' => $newbirthdate,
			);
			require_once 'ChangeDemo.php';
			$back .= Account_ChangeDemo::requestChange($this->module, $user, $data);
		}
		
		return $back;
	}
	
	private function changeFlag(GWF_User $user, $flagname, $bits)
	{
		$newFlag = Common::getPost($flagname) !== false;
		$oldFlag = $user->isOptionEnabled($bits);
		if ($newFlag === $oldFlag) { return ''; }
		if (!$user->saveOption($bits, $newFlag))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		return $this->module->message('msg_'.$flagname.($newFlag?'_on':'_off'));
	}
	
	##############
	### Avatar ###
	##############
	private function onDeleteAvatar()
	{
		$user = GWF_Session::getUser();
		$path = sprintf('dbimg/avatar/%d', $user->getID());
		
		if (Common::isFile($path))
		{
			if (false === (@unlink($path)))
			{
				return $this->module->error('err_delete_avatar');
			}
		}
		
		$user->saveOption(GWF_User::HAS_AVATAR, false);
		
		return $this->module->message('msg_deleted_avatar');
	}
	
	private function saveAvatar(array $file)
	{
		if (!GWF_Upload::isImageFile($file)) {
			return $this->module->error('err_no_image');
		}
		
		if (false === GWF_Upload::resizeImage($file, $this->module->cfgAvatarMaxWidth(), $this->module->cfgAvatarMaxHeight(), $this->module->cfgAvatarMinWidth(), $this->module->cfgAvatarMinHeight())) {
			return $this->module->error('err_no_image');
		}
		
		$user = GWF_Session::getUser();
		$uid = $user->getID();
		
		if (false === ($file = GWF_Upload::moveTo($file, 'dbimg/avatar/'.$uid))) {
			return $this->module->error('err_write_avatar');
		}
		
		$user->saveOption(GWF_User::HAS_AVATAR, true);
		$user->increase('user_avatar_v', 1);
		
		return $this->module->message('msg_avatar_saved');
	}
	
	##################
	### Validators ###
	##################
	public function validate_email(Module_Account $module, $arg)
	{
		$arg = trim($arg);
		$_POST['email'] = $arg;
		if ($arg === GWF_Session::getUser()->getVar('user_email'))
		{
			return false;
		}
		
		if (!GWF_Validator::isValidEmail($arg))
		{
			return $this->module->lang('err_email_invalid');
		}
		
		if (GWF_User::getByEmail($arg) !== false)
		{
			return $this->module->lang('err_email_taken');
		}
		
		return false;		
	}
	
	public function validate_countryid(Module_Account $module, $arg)
	{
		return GWF_CountrySelect::validate_countryid($arg, true);
	}
	
	public function validate_langid(Module_Account $module, $arg)
	{
		if (false === GWF_LangSelect::isValidLanguage($arg, true)) {
			return $this->module->lang('err_lang1');
		}
		return false;
	}
	
	public function validate_langid2(Module_Account $module, $arg)
	{
		if (false === GWF_LangSelect::isValidLanguage($arg, true)) {
			return $this->module->lang('err_lang2');
		}
		return false;
	}
	
	public function validate_birthdate(Module_Account $module, $arg)
	{
		if (false === GWF_Time::isValidDate($arg, true, 8)) {
			return $this->module->lang('err_birthdate');
		}
		return false;
	}
	
	public function validate_gender(Module_Account $module, $arg)
	{
		if (false === (GWF_Gender::isValidGender($arg))) {
			return $this->module->lang('err_gender');
		}
		return false;
	}
	
	public function validate_email_fmt(Module_Account $module, $arg)
	{
		$v = (int) $arg;
		if (!is_numeric($arg) || ($v !== GWF_User::EMAIL_TEXT && $v !== GWF_User::EMAIL_HTML) ) {
			return $this->module->lang('err_email_fmt');
		}
		return false;
	}
	
	private function onApproveMail()
	{
		$form = $this->getForm();
		
		$user = GWF_Session::getUser();
		if ('' === ($email = $user->getVar('user_email'))) {
			return $this->module->error('err_no_mail_to_approve');
		}
		
		if ($user->hasValidMail()) {
			return $this->module->error('err_already_approved');
		}

		require_once 'ChangeEmail.php';
		return Account_ChangeEmail::changeEmail($this->module, $user, $email);
	}
	
	public function validate_gpg_paste(Module_Account $module, $arg) { return false; }
	
	###########
	### GPG ###
	###########
	private function getFormGPG()
	{
		if (false === ($old_key = GWF_PublicKey::getKeyForUID(GWF_Session::getUserID()))) {
			$old_key = '';
		}
		
		$buttons = array('setup_gpg'=>$this->module->lang('btn_setup_gpg'), 'remove_gpg'=>$this->module->lang('btn_remove_gpg'));
		$data = array(
			'gpg_file' => array(GWF_Form::FILE_OPT, '', $this->module->lang('th_gpg_key'), $this->module->lang('tt_gpg_key')),
			'gpg_paste' => array(GWF_Form::MESSAGE_NOBB, $old_key, $this->module->lang('th_gpg_key2'), $this->module->lang('tt_gpg_key2')),
			'buttons' => array(GWF_Form::SUBMITS, $buttons),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onSetupGPG()
	{
		$form = $this->getFormGPG();
		if (false !== ($error = $form->validate($this->module))) {
			return $error;
		}
		
		$user = GWF_Session::getUser();
		$outfile = GWF_PATH.'extra/temp/gpg/'.$user->getVar('user_id');
//		if (!is_writable($outfile)) {
//			return GWF_HTML::err('ERR_WRITE_FILE', array($outfile));
//		}
		
		if (false !== ($row = GWF_PublicKey::getKeyForUser($user))) {
			return $this->module->error('err_gpg_fine');
		}
		
		$file_content = '';
		if (false !== ($file = $form->getVar('gpg_file')))
		{
			if (false === ($file_content = file_get_contents($file['tmp_name']))) {
				$file_content = '';
			}
		}
		else { $file_content = $form->getVar('gpg_paste'); }
		
		$file_content = trim($file_content);
		
//		if ($file_content === '') {
//			return $this->module->error('err_gpg_setup');
//		}
		
		if (strpos($file_content, '-----BEGIN ') !== 0) {
			return $this->module->error('err_gpg_raw');
		}
		
		if (false === file_put_contents($outfile, $file_content, GWF_CHMOD)) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $outfile)).'(PUTTING)';
		}
		
		if (false === ($fingerprint = GWF_PublicKey::grabFingerprint($file_content))) {
			return $this->module->error('err_gpg_key');
		}
		
		return $this->sendGPGMail($user, $fingerprint);
	}
	
	private function sendGPGMail(GWF_User $user, $fingerprint)
	{
		if ('' === ($email = $user->getValidMail())) {
			return $this->module->error('err_no_mail');
		}
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($email);
		$mail->setGPGKey($fingerprint);
		$mail->setSubject($this->module->langUser($user, 'mails_gpg'));
		$mail->setBody($this->getGPGMailBody($user, $fingerprint));
		if (false === $mail->sendToUser($user)) {
			return GWF_HTML::err('ERR_MAIL_SENT');
		}
		return $this->module->message('msg_mail_sent');
	}
	
	private function getGPGMailBody(GWF_User $user, $fingerprint)
	{
		$href = Common::getAbsoluteURL(sprintf('index.php?mo=Account&me=SetupGPGKey&userid=%s&token=%s', $user->getVar('user_id'), $fingerprint), true);
		$link = GWF_HTML::anchor($href, $href);
		return $this->module->langUser($user, 'mailb_gpg', array($user->displayUsername(), $link));
	}
	
	private function onRemoveGPG()
	{
		$_POST = array();
		
		$user = GWF_Session::getUser();
		$userid = $user->getID();
		
		if (false === GWF_PublicKey::getKeyForUID($userid)) {
			return $this->module->error('err_gpg_del');
		}
		
		if (false === GWF_PublicKey::removeKey($userid)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $user->saveOption(GWF_User::EMAIL_GPG, false)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->module->message('msg_gpg_del');
	}
}

?>
