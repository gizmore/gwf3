<?php
final class Download_Add extends GWF_Method
{
	const SESS_FILE = 'GWF_DL_TFILE';
	
	public function execute()
	{
		if (false === $this->_module->mayUpload(GWF_Session::getUser())) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== (Common::getPost('add'))) {
			return $this->onAdd();
		}
		if (false !== (Common::getPost('upload'))) {
			return $this->onUpload().$this->templateAdd();
		}
		if (false !== (Common::getPost('remove'))) {
			return $this->onRemove().$this->templateAdd();
		}
		
		return $this->templateAdd();
	}
	
	private function templateAdd()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_add')),
			'max_size' => GWF_Upload::getMaxUploadSize(),
			'max_time' => ini_get('max_execution_time'),
		);
		return $this->_module->templatePHP('add.php', $tVars);
	}
	
	private function getForm()
	{
		$data = array();
		
		if (false === ($file = $this->getFile())) {
			$name = '';
			$size = '';
		} else {
			$_POST['filename'] = $name = $file['name'];
			$size = $file['size'];
		}
		
		$data['filename'] = array(GWF_Form::STRING, $name, $this->_module->lang('th_dl_filename'));
		
		if ($file === false) {
			$data['file'] = array(GWF_Form::FILE_OPT, '', $this->_module->lang('th_file'));
			if (GWF_User::isLoggedIn()) {
				$data['upload'] = array(GWF_Form::SUBMIT, $this->_module->lang('btn_upload'));
			}
		} else {
			$data['size'] = array(GWF_Form::SSTRING, $size, $this->_module->lang('th_dl_size'));
			$data['remove'] = array(GWF_Form::SUBMIT, $this->_module->lang('btn_remove'));
		}
		$data['group'] = array(GWF_Form::SELECT, GWF_GroupSelect::single('group', Common::getPost('group')), $this->_module->lang('th_dl_gid'));
		$data['level'] = array(GWF_Form::INT, '0', $this->_module->lang('th_dl_level'));
		if (GWF_User::isAdminS()) {
			$data['price'] = array(GWF_Form::FLOAT, '0.00', $this->_module->lang('th_dl_price'));
		}
		
		$data['expire'] = array(GWF_Form::STRING, '0 seconds', $this->_module->lang('th_dl_expire'), $this->_module->lang('tt_dl_expire'));
		$data['guest_view'] = array(GWF_Form::CHECKBOX, false, $this->_module->lang('th_dl_guest_view'), $this->_module->lang('tt_dl_guest_view'));
		$data['guest_down'] = array(GWF_Form::CHECKBOX, false, $this->_module->lang('th_dl_guest_down'), $this->_module->lang('tt_dl_guest_down'));
		
		$data['adult'] = array(GWF_Form::CHECKBOX, false, $this->_module->lang('th_adult'));
		
		if (GWF_User::isLoggedIn()) {
			$data['huname'] = array(GWF_Form::CHECKBOX, false, $this->_module->lang('th_huname'));
		}
		
		$data['descr'] = array(GWF_Form::MESSAGE, '', $this->_module->lang('th_dl_descr'));
		if (!GWF_User::isLoggedIn() && $this->_module->cfgGuestCaptcha()) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		$data['add'] = array(GWF_Form::SUBMIT, $this->_module->lang('btn_add'));
		return new GWF_Form($this, $data);
	}
	
	private function onAdd()
	{
		$form = $this->getForm();
		if (false !== ($errors = $form->validate($this->_module)))
		{
			return $errors.$this->templateAdd();
		}

		if (false === ($file = $this->getFile()))
		{
			$this->uploadedFile($this->_module, $form);
			$file = $form->getVar('file');
		}
		
		$tempname = $file['tmp_name'];
		if (!file_exists($tempname))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateAdd();
		}

		$mod = $this->_module->isModerated($this->_module);
		
		$userid = GWF_Session::getUserID();
		$options = 0;
		$options |= isset($_POST['adult']) ? GWF_Download::ADULT : 0;
		$options |= isset($_POST['huname']) ? GWF_Download::HIDE_UNAME : 0;
		$options |= isset($_POST['guest_view']) ? GWF_Download::GUEST_VISIBLE : 0;
		$options |= isset($_POST['guest_down']) ? GWF_Download::GUEST_DOWNLOAD : 0;
		$options |= $mod ? 0 : GWF_Download::ENABLED;
		
		$dl = new GWF_Download(array(
			'dl_id' => 0,
			'dl_uid' => $userid,
			'dl_gid' => $form->getVar('group'),
			'dl_level' => $form->getVar('level'),
			'dl_token' => GWF_Download::generateToken(),
			'dl_count' => 0,
			'dl_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'dl_filename' => $form->getVar('filename'),
			'dl_realname' => $file['name'],
			'dl_descr' => $form->getVar('descr'),
			'dl_mime' => GWF_Upload::getMimeType($file['tmp_name']),
			'dl_price' => sprintf('%.02f', $form->getVar('price', 0.0)),
			'dl_options' => $options,
			'dl_voteid' => 0,
			'dl_purchases' => 0,
			'dl_expire' => GWF_TimeConvert::humanToSeconds($form->getVar('expire')),
		));
		if (false === $dl->insert()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateAdd();
		}
		
		$dlid = $dl->getID();
		$filename = 'dbimg/dl/'.$dlid;
		
		if (false === GWF_Upload::moveTo($file, $filename))
		{
			return GWF_HTML::err('ERR_WRITE_FILE', array( $filename)).$this->templateAdd();
		}
		
		if (false === @unlink($tempname))
		{
			return GWF_HTML::err('ERR_WRITE_FILE', array( $tempname)).$this->templateAdd();
		}
		
		if (false === $dl->createVotes($this->_module))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateAdd();
		}
		
		$this->clearFile();
		
		if ($mod)
		{
			$this->sendModMail($this->_module, $dl);
			return $this->_module->message('msg_uploaded_mod');
		}
		
		
		return $this->_module->message('msg_uploaded');
	}
	
	private function uploadedFile(Module_Download $module, GWF_Form $form)
	{
		if (false === ($file = $form->getVar('file'))) {
//			echo $this->_module->error('err_file');
			return;
		}
		$tempname = 'dbimg/dl/'.basename($file['tmp_name']);
		if (false === ($file = GWF_Upload::moveTo($file, $tempname))) {
			echo GWF_HTML::err('ERR_WRITE_FILE', array( $tempname));
		}
		GWF_Session::set(self::SESS_FILE, $file);
	}
	
	private function clearFile()
	{
		GWF_Session::remove(self::SESS_FILE);
	}
	
	private function getFile()
	{
		return GWF_Session::getOrDefault(self::SESS_FILE, false);
	}
	
	private function onUpload()
	{
		$form = $this->getForm();
		if (false === ($file = $form->getVar('file'))) {
			return GWF_HTML::err('ERR_MISSING_UPLOAD');
		}
		$this->uploadedFile($this->_module, $form);
	}
	
	private function onRemove()
	{
		$this->clearFile();
	}
	
	##################
	### Validators ###
	##################
	public function validate_file(Module_Download $m, $arg) { return false; }
	public function validate_price(Module_Download $m, $arg) { return GWF_Validator::validateDecimal($m, 'price', $arg, 0.00, 10000.00, '0.00'); }
	public function validate_filename(Module_Download $m, $arg) { return GWF_Validator::validateFilename($m, 'filename', $arg, true); }
	public function validate_group(Module_Download $m, $arg) { return GWF_Validator::validateGroupID($m, 'group', $arg, true, true); }
	public function validate_level(Module_Download $m, $arg) { return GWF_Validator::validateInt($m, 'level', $arg, 0, 3999999999, '0'); }
	public function validate_descr(Module_Download $m, $arg) { return GWF_Validator::validateString($m, 'descr', $arg, 0, $m->cfgMaxDescrLen(), false); }
	public function validate_expire(Module_Download $m, $arg) { return GWF_Time::isValidDuration($arg, 0, GWF_Time::ONE_YEAR*10) ? false : $m->lang('err_dl_expire'); }

	##################
	### Moderation ###
	##################
	private function sendModMail(Module_Download $module, GWF_Download $dl)
	{
//		$dl->setVar('', $val);
		
		$user = GWF_Session::getUser();
		foreach (GWF_UserSelect::getUsers(GWF_Group::STAFF) as $staff)
		{
			$this->sendModMailB($this->_module, $dl, $user, new GWF_User($staff));
		}
	}
	
	private function sendModMailB(Module_Download $module, GWF_Download $dl, GWF_User $uploader, GWF_User $staff)
	{
		if ('' === ($rec = $staff->getValidMail()))
		{
			return;
		}
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($rec);
		$mail->setSubject($this->_module->langUser($staff, 'mod_mail_subj'));
		
		$token = $dl->getHashcode();
		$dlid = $dl->getID();
		$url1 = "index.php?mo=Download&me=Moderate&token={$token}&dlid={$dlid}&action=download";
		$url2 = "index.php?mo=Download&me=Moderate&token={$token}&dlid={$dlid}&action=allow";
		$url3 = "index.php?mo=Download&me=Moderate&token={$token}&dlid={$dlid}&action=delete";
		
		$args = array(
			$staff->displayUsername(),
			$uploader->displayUsername(),
			$dl->display('dl_filename'),
			$dl->display('dl_realname'),
			$dl->display('dl_mime'),
			$dl->getFilesize(),
			$dl->display('dl_descr'),
			Common::getAbsoluteURL($url1, true),
			Common::getAbsoluteURL($url2, true),
			Common::getAbsoluteURL($url3, true),
		);
		
		$mail->setBody($this->_module->langUser($staff, 'mod_mail_body', $args));
		
		$mail->sendToUser($staff);
	}
}
?>
