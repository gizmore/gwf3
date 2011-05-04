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

	public function execute(GWF_Module $module)
	{
		if (false === ($this->attach = GWF_ForumAttachment::getByID(Common::getGet('aid', 0)))) {
			return $module->error('err_attach');
		}
		
		if (false === ($this->post = $this->attach->getPost())) {
			return $module->error('err_post');
		}
		
		if (!$this->post->hasEditPermission()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== Common::getPost('edit')) {
			return $this->onEdit($module).$this->templateEdit($module);
		}
		
		if (false !== Common::getPost('delete')) {
			return $this->onDelete($module);
		}
		
		return $this->templateEdit($module);
	}

	private function formEdit(Module_Forum $module)
	{
		$buttons = array('edit'=>$module->lang('btn_edit_attach'), 'delete'=>$module->lang('btn_del_attach'));
		$data = array();
		$data['file']  = array(GWF_Form::FILE_OPT, '', $module->lang('th_attach_file'));
		$data['guest_view'] = array(GWF_Form::CHECKBOX, $this->attach->isGuestView(), $module->lang('th_guest_view'));
		$data['guest_down'] = array(GWF_Form::CHECKBOX, $this->attach->isGuestDown(), $module->lang('th_guest_down'));
		$data['buttons'] = array(GWF_Form::SUBMITS, $buttons);
		return new GWF_Form($this, $data);
	}
	
	private function templateEdit(Module_Forum $module)
	{
		$form = $this->formEdit($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_edit_attach')),
		);
		return $module->templatePHP('edit_attach.php', $tVars);
	}
	
	private function onDelete(Module_Forum $module)
	{
		$form = $this->formEdit($module);
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}
		
		if (false === $this->attach->delete()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$this->post->increase('post_attachments', -1);
		
		return $module->message('msg_attach_deleted', array($this->post->getShowHREF()));
	}
	
	private function onEdit(Module_Forum $module)
	{
		$form = $this->formEdit($module);
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}
		
		$prepend = '';
		
		# Re-Upload
		if ( (false !== ($file = $form->getVar('file'))) & ($file['size'] !== 0) )
		{
			if (false !== ($error = $this->unReUpload($module, $file, $this->attach))) {
				return $error;
			} 
			$prepend = $module->message('msg_reupload');
		}
		
		# Save option
		$this->attach->saveOption(GWF_ForumAttachment::GUEST_VISIBLE, isset($_POST['guest_view']));
		$this->attach->saveOption(GWF_ForumAttachment::GUEST_DOWNLOAD, isset($_POST['guest_down']));
		
		return $prepend.$module->message('msg_attach_edited',  array($this->post->getShowHREF()));
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