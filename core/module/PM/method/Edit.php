<?php

final class PM_Edit extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^pm/edit/(\d+)/? index.php?mo=PM&me=Edit&pmid=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize())) {
			return $error;
		}
		
		if (false !== Common::getPost('edit')) {
			return $this->onEdit();
		}
		
		if (false !== Common::getPost('preview')) {
			return $this->onPreview();
		}
		
		return $this->templateEdit();
	}
	
	/**
	 * @var GWF_PM
	 */
	private $pm;
	private function sanitize()
	{
		if (false === ($this->pm = GWF_PM::getByID(Common::getGet('pmid')))) {
			return $this->module->error('err_pm');
		}
		if ($this->pm->isRead()) {
			return $this->module->error('err_pm_read');
		}
		if (false === $this->pm->canEdit(GWF_Session::getUser())) {
			return $this->module->error('err_perm_write');
		}
		return false;
	}
	
	private function getForm()
	{
		$buttons = array(
			'preview' => $this->module->lang('btn_preview'),
			'edit' => $this->module->lang('btn_edit'),
		);
		$data = array(
			'title' => array(GWF_Form::STRING, $this->pm->getVar('pm_title'), $this->module->lang('th_pm_title')),
			'message' => array(GWF_Form::MESSAGE, $this->pm->getVar('pm_message'), $this->module->lang('th_pm_message')),
			'cmds' => array(GWF_Form::SUBMITS, $buttons),
		);
		return new GWF_Form($this, $data);
	}

	private function templateEdit($preview='')
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_edit')),
			'preview' => $preview,
		);
		return $this->module->template('edit.tpl', $tVars);
	}
	
	private function onPreview()
	{
		$form = $this->getForm();
		$errors = $form->validate($this->module);
		$preview = $this->templatePreview($form);
		return $errors.$this->templateEdit($preview);
	}
	
	private function templatePreview(GWF_Form $form)
	{
		$tVars = array(
			'pm' => GWF_PM::fakePM($this->pm->getSender()->getID(), $this->pm->getReceiver()->getID(), $form->getVar('title'), $form->getVar('message')),
			'actions' => false,
			'title' => $this->module->lang('ft_preview'),
			'unread' => array(),
		);
		return $this->module->templatePHP('show.php', $tVars);
	}

	private function onEdit()
	{
		$form = $this->getForm();
		if (false !== ($errors = $form->validate($this->module))) {
			return $errors.$this->templateEdit();
		}
		
		$data = array(
			'pm_title' => $form->getVar('title'),
			'pm_message' => $form->getVar('message'),
		);
		
		
		if (false === $this->pm->saveVars($data)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false !== ($pm2 = $this->pm->getOtherPM())) {
			if (false === ($pm2->saveVars($data))) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}
		
		return $this->module->message('msg_edited').$this->module->requestMethodB('Overview');
	}
	
	public function validate_title(Module_PM $module, $arg) { return $this->module->validate_title($arg); }
	public function validate_message(Module_PM $module, $arg) { return $this->module->validate_message($arg); }
}

?>
