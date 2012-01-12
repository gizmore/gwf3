<?php
final class Download_Edit extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($dl = GWF_Download::getByID(Common::getGet('id')))) {
			return $this->_module->error('err_dlid');
		}
		
		if (!$dl->mayEdit(GWF_Session::getUser())) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== (Common::getPost('edit'))) {
			return $this->onEdit($this->_module, $dl);
		}
		if (false !== (Common::getPost('delete'))) {
			return $this->onDelete($this->_module, $dl);
		}
		if (false !== (Common::getPost('reup'))) {
			return $this->onReup($this->_module, $dl);
		}
		
		return $this->templateEdit($this->_module, $dl);
	}
	
	private function templateEdit(Module_Download $module, GWF_Download $dl)
	{
		$form = $this->getForm($this->_module, $dl);
		
		$form_reup = '';
		if (!$this->_module->isModerated($this->_module))
		{
			$form_reup = $this->getFormReup($this->_module, $dl);
			$form_reup = $form_reup->templateY($this->_module->lang('ft_reup'));
		}
		
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_edit')),
			'form_reup' => $form_reup,
		);
		return $this->_module->templatePHP('edit.php', $tVars);
	}
	
	private function getFormReup(Module_Download $module, GWF_Download $dl)
	{
		$data = array();
		$data['file'] = array(GWF_Form::FILE, '', $this->_module->lang('th_file'));
		$data['reup'] = array(GWF_Form::SUBMIT, $this->_module->lang('btn_upload'));
		return new GWF_Form($this, $data);
	}
	
	private function getForm(Module_Download $module, GWF_Download $dl)
	{
		$data = array();
		
		$data['filename'] = array(GWF_Form::STRING, $dl->getVar('dl_filename'), $this->_module->lang('th_dl_filename'));
		$data['group'] = array(GWF_Form::SELECT, GWF_GroupSelect::single('group', $dl->getVar('dl_gid')), $this->_module->lang('th_dl_gid'));
		$data['level'] = array(GWF_Form::INT, $dl->getVar('dl_level'), $this->_module->lang('th_dl_level'));
		if (GWF_User::isAdminS())
		{
			$data['price'] = array(GWF_Form::FLOAT, $dl->getVar('dl_price'), $this->_module->lang('th_dl_price'));
		}
		
		$data['expire'] = array(GWF_Form::STRING, GWF_Time::humanDuration($dl->getVar('dl_expire')), $this->_module->lang('th_dl_expire'), $this->_module->lang('tt_dl_expire'));
		$data['guest_view'] = array(GWF_Form::CHECKBOX, $dl->isOptionEnabled(GWF_Download::GUEST_VISIBLE), $this->_module->lang('th_dl_guest_view'), $this->_module->lang('tt_dl_guest_view'));
		$data['guest_down'] = array(GWF_Form::CHECKBOX, $dl->isOptionEnabled(GWF_Download::GUEST_DOWNLOAD), $this->_module->lang('th_dl_guest_down'), $this->_module->lang('tt_dl_guest_down'));
		$data['adult'] = array(GWF_Form::CHECKBOX, $dl->isOptionEnabled(GWF_Download::ADULT), $this->_module->lang('th_adult'));
		$data['huname'] = array(GWF_Form::CHECKBOX, $dl->isOptionEnabled(GWF_Download::HIDE_UNAME), $this->_module->lang('th_huname'));
		$data['enabled'] = array(GWF_Form::CHECKBOX, $dl->isEnabled(), $this->_module->lang('th_enabled'));
		
		$data['descr'] = array(GWF_Form::MESSAGE, $dl->getVar('dl_descr'), $this->_module->lang('th_dl_descr'));
		
		$data['buttons'] = array(GWF_Form::SUBMITS, array('edit'=>$this->_module->lang('btn_edit'),'delete'=>$this->_module->lang('btn_delete')));

		return new GWF_Form($this, $data);
	}

	##################
	### Validators ###
	##################
	public function validate_price(Module_Download $m, $arg) { return GWF_Validator::validateDecimal($m, 'price', $arg, 0.00, 10000.00, '0.00'); }
	public function validate_filename(Module_Download $m, $arg) { return GWF_Validator::validateFilename($m, 'filename', $arg, true); }
	public function validate_group(Module_Download $m, $arg) { return GWF_Validator::validateGroupID($m, 'group', $arg, true, true); }
	public function validate_level(Module_Download $m, $arg) { return GWF_Validator::validateInt($m, 'level', $arg, 0, 3999999999, '0'); }
	public function validate_descr(Module_Download $m, $arg) { return GWF_Validator::validateString($m, 'descr', $arg, 0, $m->cfgMaxDescrLen(), false); }
	public function validate_expire(Module_Download $m, $arg) { return GWF_Time::isValidDuration($arg, 0, GWF_Time::ONE_YEAR*10) ? false : $m->lang('err_dl_expire'); }
	public function validate_file(Module_Download $m, $arg) { return false; }
	
	private function onEdit(Module_Download $module, GWF_Download $dl)
	{
		$form = $this->getForm($this->_module, $dl);
		if (false !== ($err = $form->validate($this->_module))) {
			return $err.$this->templateEdit($this->_module, $dl);
		}

		if (GWF_User::isAdminS()) {
			if (false === $dl->saveVar('dl_price', $form->getVar('price'))) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateEdit($this->_module, $dl);
			}
		}
		
		$options = 0;
		$options |= isset($_POST['enabled']) ? GWF_Download::ENABLED : 0;
		$options |= isset($_POST['adult']) ? GWF_Download::ADULT : 0;
		$options |= isset($_POST['huname']) ? GWF_Download::HIDE_UNAME : 0;
		$options |= isset($_POST['guest_view']) ? GWF_Download::GUEST_VISIBLE : 0;
		$options |= isset($_POST['guest_down']) ? GWF_Download::GUEST_DOWNLOAD : 0;
		
		if (false === $dl->saveVars(array(
			'dl_filename' => $form->getVar('filename'),
			'dl_gid' => $form->getVar('group'),
			'dl_level' => $form->getVar('level'),
			'dl_descr' => $form->getVar('descr'),
			'dl_options' => $options,
			'dl_expire' => GWF_TimeConvert::humanToSeconds($form->getVar('expire')),
		)))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateEdit($this->_module, $dl);
		}

		return $this->_module->message('msg_edited').$this->templateEdit($this->_module, $dl);
	}

	private function onDelete(Module_Download $module, GWF_Download $dl)
	{
		if (false === $dl->getVotes()->onDelete()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}

		if (false === $dl->delete()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_deleted');
	}
	
	private function onReup(Module_Download $module, GWF_Download $dl)
	{
		$form = $this->getFormReup($this->_module, $dl);
		if (false !== ($err = $form->validate($this->_module))) {
			return $err.$this->templateEdit($this->_module, $dl);
		}
		
		if (false === ($file = $form->getVar('file')))
		{
			return $this->_module->error('err_file').$this->templateEdit($this->_module, $dl);
		}
		
		if ($this->_module->isModerated($this->_module))
		{
			return GWF_HTML::err('ERR_NO_PERMISSION').$this->templateEdit($this->_module, $dl);
		}
		
		$tempname = 'dbimg/dl/'.$dl->getVar('dl_id');
		if (false === ($file = GWF_Upload::moveTo($file, $tempname))) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $tempname)).$this->templateEdit($this->_module, $dl);
		}
		
		if (false === $dl->saveVars(array(
			'dl_uid' => GWF_Session::getUserID(),
			'dl_mime' => GWF_Upload::getMimeType($file['tmp_name']),
			'dl_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_uploaded').$this->templateEdit($this->_module, $dl);
	}
	
}
?>