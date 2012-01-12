<?php
final class Forum_EditAttach extends GWF_Method
{
	/**
	 * @var GWF_ForumPost
	 */
	private $post;
	
	/**
	 * @var GWF_ForumAttachment
	 */
	private $attach;
	
	public function isLoginRequired() { return true; }

	public function execute()
	{
		if (false === ($this->attach = GWF_ForumAttachment::getByID(Common::getGet('aid', 0)))) {
			return $this->_module->error('err_attach');
		}
		
		if (false === ($this->post = $this->attach->getPost())) {
			return $this->_module->error('err_post');
		}
		
		if (!$this->post->hasEditPermission()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== Common::getPost('edit')) {
			return $this->onEdit($this->_module).$this->templateEdit($this->_module);
		}
		
		if (false !== Common::getPost('delete')) {
			return $this->onDelete($this->_module);
		}
		
		return $this->templateEdit($this->_module);
	}

	private function formEdit()
	{
		$buttons = array('edit'=>$this->_module->lang('btn_edit_attach'), 'delete'=>$this->_module->lang('btn_del_attach'));
		$data = array();
		$data['file']  = array(GWF_Form::FILE_OPT, '', $this->_module->lang('th_attach_file'));
		$data['guest_view'] = array(GWF_Form::CHECKBOX, $this->attach->isGuestView(), $this->_module->lang('th_guest_view'));
		$data['guest_down'] = array(GWF_Form::CHECKBOX, $this->attach->isGuestDown(), $this->_module->lang('th_guest_down'));
		$data['buttons'] = array(GWF_Form::SUBMITS, $buttons);
		return new GWF_Form($this, $data);
	}
	
	private function templateEdit()
	{
		$form = $this->formEdit($this->_module);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_edit_attach')),
		);
		return $this->_module->templatePHP('edit_attach.php', $tVars);
	}
	
	private function onDelete()
	{
		$form = $this->formEdit($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error;
		}
		
		if (false === $this->attach->delete()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$this->post->increase('post_attachments', -1);
		
		return $this->_module->message('msg_attach_deleted', array($this->post->getShowHREF()));
	}
	
	private function onEdit()
	{
		$form = $this->formEdit($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error;
		}
		
		$prepend = '';
		
		# Re-Upload
		if ( (false !== ($file = $form->getVar('file'))) & ($file['size'] !== 0) )
		{
			if (false !== ($error = $this->unReUpload($this->_module, $file, $this->attach))) {
				return $error;
			} 
			$prepend = $this->_module->message('msg_reupload');
		}
		
		# Save option
		$this->attach->saveOption(GWF_ForumAttachment::GUEST_VISIBLE, isset($_POST['guest_view']));
		$this->attach->saveOption(GWF_ForumAttachment::GUEST_DOWNLOAD, isset($_POST['guest_down']));
		
		return $prepend.$this->_module->message('msg_attach_edited',  array($this->post->getShowHREF()));
	}

	private function unReUpload(Module_Forum $module, array $file, GWF_ForumAttachment $attach)
	{
		$temp = $file['tmp_name'];
		$target = $attach->dbimgPath();
		$success = GWF_Upload::moveTo($file, $target);
		@unlink($temp);
		
		if (!$success) {
			return GWF_HTML::err('ERR_WRITE_FILE', $target);
		}

		if (false === $attach->saveVars(array(
			'fatt_mime' => GWF_Upload::getMimeType($target),
			'fatt_size' => filesize($target),
			'fatt_downloads' => 0,
			'fatt_filename' => $file['name'],
			'fatt_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return false;
	}
}
?>