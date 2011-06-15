<?php
/**
 * Change account settings
 * @author gizmore
 */
final class Account_Form extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^account/?$ index.php?mo=Account&me=Form'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (isset($_POST['delete'])) {
			die(GWF_Website::redirect($module->getMethodURL('Delete')));
		}
		if (false !== (Common::getPost('drop_avatar'))) {
			return $this->onDeleteAvatar($module).$this->templateForm($module);
		}
		if (false !== (Common::getPost('change'))) {
			return $this->onChange($module).$this->templateForm($module);
		}
		if (false !== Common::getPost('approvemail')) {
			return $this->onApproveMail($module).$this->templateForm($module);
		}
		if (false !== Common::getPost('setup_gpg')) {
			return $this->onSetupGPG($module).$this->templateForm($module);
		}
		if (false !== Common::getPost('remove_gpg')) {
			return $this->onRemoveGPG($module).$this->templateForm($module);
		}
		return $this->templateForm($module);
	}
	
	private function templateForm(Module_Account $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('form_title')),
		);
		
		if (function_exists('gnupg_init'))
		{
			$formGPG = $this->getFormGPG($module);
			$tVars['form_gpg'] = $formGPG->templateY($module->lang('ft_gpg'));
		}
		else
		{
			$tVars['form_gpg'] = '';
		}
		
		return $module->templatePHP('form.php', $tVars);
	}
	
	################
	### The Form ###
	################
	public function getForm(Module_Account $module)
	{
		$user = GWF_Session::getUser();
		$user_email = $user->getVar('user_email');
		
		# SECURITY
		$data = array(
			'username' => array(GWF_Form::SSTRING, $user->getVar('user_name'), $module->lang('th_username')),
			'email' => array(GWF_Form::STRING, $user_email, $module->lang('th_email')),
		);
		
		### Email set but not approved.
		if ($user_email !== '' && !$user->hasValidMail()) {
			$data['approvemail'] = array(GWF_Form::SUBMIT, $module->lang('btn_approvemail'), $module->lang('th_approvemail'));
		}
		
		// DEMOGRAPHICS
		$data['div1'] = array(GWF_Form::HEADLINE, $module->lang('th_demo', array(GWF_Time::humanDuration($module->cfgChangeTime()), 1)));
		$data['countryid'] = array(GWF_Form::SELECT, $user->getCountrySelect('countryid'), $module->lang('th_countryid'));
		$data['langid'] = array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'langid', Common::getPostString('langid', $user->getVar('user_langid'))), $module->lang('th_langid'));
		$data['langid2'] = array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'langid2', Common::getPostString('langid2', $user->getVar('user_langid2'))), $module->lang('th_langid2'));
		$data['birthdate'] = array(GWF_Form::DATE, $user->getVar('user_birthdate'), $module->lang('th_birthdate'), 'foo', GWF_Date::LEN_DAY);
		if ($module->cfgShowGender())
		{
			$data['gender'] = array(GWF_Form::SELECT, $user->getGenderSelect(), $module->lang('th_gender'));
		}
		// OPTIONS
		$data['div2'] = array(GWF_Form::HEADLINE, $module->lang('th_flags'));
		
		$data['email_fmt'] = array(GWF_Form::SELECT, $this->selectEMailFormat($module, $user), $module->lang('th_email_fmt'));
		
		if ($module->cfgShowCheckboxes())
		{
			$data['online'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::HIDE_ONLINE), $module->lang('th_online'));
			$data['show_bday'] = array(GWF_Form::CHECKBOX,  $user->isOptionEnabled(GWF_User::SHOW_BIRTHDAY), $module->lang('th_show_bday'));
			$data['show_obday'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::SHOW_OTHER_BIRTHDAYS), $module->lang('th_show_obday'));
			$data['show_email'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::SHOW_EMAIL), $module->lang('th_show_email'));
			$data['allow_email'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::ALLOW_EMAIL), $module->lang('th_allow_email'));
		}
		
		
		if ($module->cfgShowAdult())
		{
			if (GWF_Time::getAge($user->getVar('user_birthdate')) >= $module->cfgAdultAge()) {
				$data['adult'] = array(GWF_Form::CHECKBOX, $user->isOptionEnabled(GWF_User::WANTS_ADULT), $module->lang('th_adult'));
			}
		}
				
		if ($module->cfgUseAvatar())
		{
			// Avatar
			if ($user->isOptionEnabled(GWF_User::HAS_AVATAR))
			{
				$data['avatar'] = array(GWF_Form::HEADLINE, $user->displayAvatar(), $module->lang('th_avatar'));
				$data['drop_avatar'] = array(GWF_Form::SUBMIT, $module->lang('btn_drop_avatar'), '');
			}
			else
			{
				$data['avatar'] = array(GWF_Form::FILE_OPT, '', $module->lang('th_avatar'));
			}
		}
		
		$data['divpw'] = array(GWF_Form::HEADLINE, $module->lang('th_change_pw', array( 'recovery')));
		
		// BTN
		$buttons = array('change'=>$module->lang('btn_submit'),'delete'=>$module->lang('btn_delete'));
//		$data['change'] = array(GWF_Form::SUBMIT, $module->lang('btn_submit'), '');
		$data['buttons'] = array(GWF_Form::SUBMITS, $buttons);		
		return new GWF_Form($this, $data);
	}

	#######################
	### Change Settings ###
	#######################
	private function selectEMailFormat(Module_Account $module, GWF_User $user)
	{
		$data = array(
			array(GWF_User::EMAIL_HTML, $module->lang('email_fmt_html')),
			array(GWF_User::EMAIL_TEXT, $module->lang('email_fmt_text')),
		);
		$selected = $user->isOptionEnabled(GWF_User::EMAIL_TEXT) ? GWF_User::EMAIL_TEXT : 0;
		return GWF_Select::display('email_fmt', $data, $selected);
	}
	
	private function onChange(Module_Account $module)
	{
		$back = '';
		$user = GWF_Session::getUser();
		$form = $this->getForm($module);
		if (false !== ($errors = $form->validate($module))) {
			return $errors;
		}
		
		# Upload Avatar
		if (false !== ($file = $form->getVar('avatar'))) {
			$back .= $this->saveAvatar($module, $file);
			Common::unlink($file['tmp_name']);
		}

		
		# Flags
		if ($module->cfgShowAdult() && GWF_Time::getAge($user->getVar('user_birthdate')) > $module->cfgAdultAge()) {
			$back .= $this->changeFlag($module, $user, 'adult', GWF_USER::WANTS_ADULT);
		}
		$back .= $this->changeFlag($module, $user, 'online', GWF_USER::HIDE_ONLINE);
		$back .= $this->changeFlag($module, $user, 'show_bday', GWF_USER::SHOW_BIRTHDAY);
		$back .= $this->changeFlag($module, $user, 'show_obday', GWF_USER::SHOW_OTHER_BIRTHDAYS);
		$back .= $this->changeFlag($module, $user, 'show_email', GWF_USER::SHOW_EMAIL);
		$back .= $this->changeFlag($module, $user, 'allow_email', GWF_USER::ALLOW_EMAIL);
		
		
		# Email Format
		$newfmt = (int) $_POST['email_fmt'];
		$oldfmt = $user->isOptionEnabled(GWF_User::EMAIL_TEXT) ? GWF_User::EMAIL_TEXT : 0;
		if ($newfmt !== $oldfmt) {
			$user->saveOption(GWF_User::EMAIL_TEXT, $newfmt > 0);
			$back .= $module->message('msg_email_fmt_'.$newfmt);
		}
		
		# Change EMAIL
		$newmail =$form->getVar('email');
		$oldmail = $user->getVar('user_email');
		if ($newmail !== $oldmail) {
			require_once 'ChangeEmail.php';
			$back .= Account_ChangeEmail::changeEmail($module, $user, $newmail);
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
			$back .= Account_ChangeDemo::requestChange($module, $user, $data);
		}
		
		return $back;
	}
	
	private function changeFlag(Module_Account $module, GWF_User $user, $flagname, $bits)
	{
		$newFlag = Common::getPost($flagname) !== false;
		$oldFlag = $user->isOptionEnabled($bits);
		if ($newFlag === $oldFlag) { return ''; }
		if (false === $user->saveOption($bits, $newFlag)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		return $module->message('msg_'.$flagname.($newFlag?'_on':'_off'));
	}
	
	##############
	### Avatar ###
	##############
	private function onDeleteAvatar(Module_Account $module)
	{
		$user = GWF_Session::getUser();
		$path = sprintf('dbimg/avatar/%d', $user->getID());
		
		if (Common::isFile($path))
		{
			if (false === (@unlink($path)))
			{
				return $module->error('err_delete_avatar');
			}
		}
		
		$user->saveOption(GWF_User::HAS_AVATAR, false);
		
		return $module->message('msg_deleted_avatar');
	}
	
	private function saveAvatar(Module_Account $module, array $file)
	{
		if (!GWF_Upload::isImageFile($file)) {
			return $module->error('err_no_image');
		}
		
		if (false === GWF_Upload::resizeImage($file, $module->cfgAvatarMaxWidth(), $module->cfgAvatarMaxHeight(), $module->cfgAvatarMinWidth(), $module->cfgAvatarMinHeight())) {
			return $module->error('err_no_image');
		}
		
		$user = GWF_Session::getUser();
		$uid = $user->getID();
		
		if (false === ($file = GWF_Upload::moveTo($file, 'dbimg/avatar/'.$uid))) {
			return $module->error('err_write_avatar');
		}
		
		$user->saveOption(GWF_User::HAS_AVATAR, true);
		$user->increase('user_avatar_v', 1);
		
		return $module->message('msg_avatar_saved');
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
			return $module->lang('err_email_invalid');
		}
		
		if (GWF_User::getByEmail($arg) !== false)
		{
			return $module->lang('err_email_taken');
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
			return $module->lang('err_lang1');
		}
		return false;
	}
	
	public function validate_langid2(Module_Account $module, $arg)
	{
		if (false === GWF_LangSelect::isValidLanguage($arg, true)) {
			return $module->lang('err_lang2');
		}
		return false;
	}
	
	public function validate_birthdate(Module_Account $module, $arg)
	{
		if (false === GWF_Time::isValidDate($arg, true, 8)) {
			return $module->lang('err_birthdate');
		}
		return false;
	}
	
	public function validate_gender(Module_Account $module, $arg)
	{
		if (false === (GWF_Gender::isValidGender($arg))) {
			return $module->lang('err_gender');
		}
		return false;
	}
	
	public function validate_email_fmt(Module_Account $module, $arg)
	{
		$v = (int) $arg;
		if (!is_numeric($arg) || ($v !== GWF_User::EMAIL_TEXT && $v !== GWF_User::EMAIL_HTML) ) {
			return $module->lang('err_email_fmt');
		}
		return false;
	}
	
	private function onApproveMail(Module_Account $module)
	{
		$form = $this->getForm($module);
		
		$user = GWF_Session::getUser();
		if ('' === ($email = $user->getVar('user_email'))) {
			return $module->error('err_no_mail_to_approve');
		}
		
		if ($user->hasValidMail()) {
			return $module->error('err_already_approved');
		}

		require_once 'ChangeEmail.php';
		return Account_ChangeEmail::changeEmail($module, $user, $email);
	}
	
	public function validate_gpg_paste(Module_Account $module, $arg) { return false; }
	
	###########
	### GPG ###
	###########
	private function getFormGPG(Module_Account $module)
	{
		if (false === ($old_key = GWF_PublicKey::getKeyForUID(GWF_Session::getUserID()))) {
			$old_key = '';
		}
		
		$buttons = array('setup_gpg'=>$module->lang('btn_setup_gpg'), 'remove_gpg'=>$module->lang('btn_remove_gpg'));
		$data = array(
			'gpg_file' => array(GWF_Form::FILE_OPT, '', $module->lang('th_gpg_key'), 0, '', $module->lang('tt_gpg_key'), false),
			'gpg_paste' => array(GWF_Form::MESSAGE_NOBB, $old_key, $module->lang('th_gpg_key2'), 0, '', $module->lang('tt_gpg_key2'), false),
			'buttons' => array(GWF_Form::SUBMITS, $buttons),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onSetupGPG(Module_Account $module)
	{
		$form = $this->getFormGPG($module);
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}
		
		$user = GWF_Session::getUser();
		$outfile = 'temp/gpg/'.$user->getVar('user_id');
//		if (!is_writable($outfile)) {
//			return GWF_HTML::err('ERR_WRITE_FILE', array($outfile));
//		}
		
		if (false !== ($row = GWF_PublicKey::getKeyForUser($user))) {
			return $module->error('err_gpg_fine');
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
//			return $module->error('err_gpg_setup');
//		}
		
		if (strpos($file_content, '-----BEGIN ') !== 0) {
			return $module->error('err_gpg_raw');
		}
		
		if (false === file_put_contents($outfile, $file_content, GWF_CHMOD)) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $outfile)).'(PUTTING)';
		}
		
		if (false === ($fingerprint = GWF_PublicKey::grabFingerprint($file_content))) {
			return $module->error('err_gpg_key');
		}
		
		return $this->sendGPGMail($module, $user, $fingerprint);
	}
	
	private function sendGPGMail(Module_Account $module, GWF_User $user, $fingerprint)
	{
		if ('' === ($email = $user->getValidMail())) {
			return $module->error('err_no_mail');
		}
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($email);
		$mail->setGPGKey($fingerprint);
		$mail->setSubject($module->langUser($user, 'mails_gpg'));
		$mail->setBody($this->getGPGMailBody($module, $user, $fingerprint));
		if (false === $mail->sendToUser($user)) {
			return GWF_HTML::err('ERR_MAIL_SENT');
		}
		return $module->message('msg_mail_sent');
	}
	
	private function getGPGMailBody(Module_Account $module, GWF_User $user, $fingerprint)
	{
		$href = Common::getAbsoluteURL(sprintf('index.php?mo=Account&me=SetupGPGKey&userid=%s&token=%s', $user->getVar('user_id'), $fingerprint), true);
		$link = GWF_HTML::anchor($href, $href);
		return $module->langUser($user, 'mailb_gpg', array($user->displayUsername(), $link));
	}
	
	private function onRemoveGPG(Module_Account $module)
	{
		$_POST = array();
		
		$user = GWF_Session::getUser();
		$userid = $user->getID();
		
		if (false === GWF_PublicKey::getKeyForUID($userid)) {
			return $module->error('err_gpg_del');
		}
		
		if (false === GWF_PublicKey::removeKey($userid)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $user->saveOption(GWF_User::EMAIL_GPG, false)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $module->message('msg_gpg_del');
	}
}

?>
