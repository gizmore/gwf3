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
			return $this->module->error('err_attach');
		}
		
		if (false === ($this->post = $this->attach->getPost())) {
			return $this->module->error('err_post');
		}
		
		if (!$this->post->hasEditPermission()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== Common::getPost('edit')) {
			return $this->onEdit().$this->templateEdit();
		}
		
		if (false !== Common::getPost('delete')) {
			return $this->onDelete();
		}
		
		return $this->templateEdit();
	}

	private function formEdit()
	{
		$buttons = array('edit'=>$this->module->lang('btn_edit_attach'), 'delete'=>$this->module->lang('btn_del_attach'));
		$data = array();
		$data['file']  = array(GWF_Form::FILE_OPT, '', $this->module->lang('th_attach_file'));
		$data['guest_view'] = array(GWF_Form::CHECKBOX, $this->attach->isGuestView(), $this->module->lang('th_guest_view'));
		$data['guest_down'] = array(GWF_Form::CHECKBOX, $this->attach->isGuestDown(), $this->module->lang('th_guest_down'));
		$data['buttons'] = array(GWF_Form::SUBMITS, $buttons);
		return new GWF_Form($this, $data);
	}
	
	private function templateEdit()
	{
		$form = $this->formEdit();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_edit_attach')),
		);
		return $this->module->templatePHP('edit_attach.php', $tVars);
	}
	
	private function onDelete()
	{
		$form = $this->formEdit();
		if (false !== ($error = $form->validate($this->module))) {
			return $error;
		}
		
		if (false === $this->attach->delete()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$this->post->increase('post_attachments', -1);
		
		return $this->module->message('msg_attach_deleted', array($this->post->getShowHREF()));
	}
	
	private function onEdit()
	{
		$form = $this->formEdit();
		if (false !== ($error = $form->validate($this->module))) {
			return $error;
		}
		
		$prepend = '';
		
		# Re-Upload
		if ( (false !== ($file = $form->getVar('file'))) & ($file['size'] !== 0) )
		{
			if (false !== ($error = $this->unReUpload($file, $this->attach))) {
				return $error;
			} 
			$prepend = $this->module->message('msg_reupload');
		}
		
		# Save option
		$this->attach->saveOption(GWF_ForumAttachment::GUEST_VISIBLE, isset($_POST['guest_view']));
		$this->attach->saveOption(GWF_ForumAttachment::GUEST_DOWNLOAD, isset($_POST['guest_down']));
		
		return $prepend.$this->module->message('msg_attach_edited',  array($this->post->getShowHREF()));
	}

	private function unReUpload(array $file, GWF_ForumAttachment $attach)
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