<?php
final class Forum_AddAttach extends GWF_Method
{
	/**
	 * @var GWF_ForumPost
	 */
	private $post;
	
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^forum/add/attachment/to/post/(\d+)/[^/]+$ index.php?mo=Forum&me=AddAttach&pid=$1'.PHP_EOL;
	}

	public function execute()
	{
		if (false === ($this->post = GWF_ForumPost::getPost(Common::getGet('pid', 0)))) {
			return $this->_module->error('err_post');
		}
		if (!$this->post->hasEditPermission()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== Common::getPost('add')) {
			return $this->onAdd();
		}
		
		return $this->templateAdd();
	}
	
	private function formAdd()
	{
		$is_guest = $this->post->isOptionEnabled(GWF_ForumPost::GUEST_VIEW);
		$data = array();
		$data['file']  = array(GWF_Form::FILE, '', $this->_module->lang('th_attach_file'));
		$data['guest_view'] = array(GWF_Form::CHECKBOX, $is_guest, $this->_module->lang('th_guest_view'));
		$data['guest_down'] = array(GWF_Form::CHECKBOX, $is_guest, $this->_module->lang('th_guest_down'));
		$data['add'] = array(GWF_Form::SUBMIT, $this->_module->lang('btn_add_attach'));
		return new GWF_Form($this, $data);
	}
	
	private function templateAdd()
	{
		$form = $this->formAdd();
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_add_attach')),
		);
		return $this->_module->templatePHP('add_attach.php', $tVars);
	}
	
	public function validate_file($module, $arg) { return false; }

	private function onAdd()
	{
		$form = $this->formAdd();
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->templateAdd();
		}
		
		$file = $form->getVar('file');
		$tmp = $file['tmp_name'];
		
		$postid = $this->post->getID();
		$userid = GWF_Session::getUserID();
		
		$options = 0;
		$options |= isset($_POST['guest_view']) ? GWF_ForumAttachment::GUEST_VISIBLE : 0;
		$options |= isset($_POST['guest_down']) ? GWF_ForumAttachment::GUEST_DOWNLOAD : 0;
		
		# Put in db
		$attach = new GWF_ForumAttachment(array(
			'fatt_aid' => 0,
			'fatt_uid' => $userid,
			'fatt_pid' => $postid,
			'fatt_mime' => GWF_Upload::getMimeType($tmp),
			'fatt_size' => filesize($tmp),
			'fatt_downloads' => 0,
			'fatt_filename' => $file['name'],
			'fatt_options' => $options,
			'fatt_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		));
		if (false === $attach->insert()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$aid = $attach->getID();

		# Copy file
		$path = $attach->dbimgPath();
		if (false === GWF_Upload::moveTo($file, $path))
		{
			@unlink($tmp);
			return GWF_HTML::err('ERR_WRITE_FILE', $path);
		}
		@unlink($tmp);
		
		
		$this->post->increase('post_attachments', 1);
		
		return $this->_module->message('msg_attach_added', array($this->post->getShowHREF()));
	}
}
?>