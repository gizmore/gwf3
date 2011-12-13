<?php

final class PM_Edit extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^pm/edit/(\d+)/? index.php?mo=PM&me=Edit&pmid=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		
		if (false !== Common::getPost('edit')) {
			return $this->onEdit($module);
		}
		
		if (false !== Common::getPost('preview')) {
			return $this->onPreview($module);
		}
		
		return $this->templateEdit($module);
	}
	
	/**
	 * @var GWF_PM
	 */
	private $pm;
	private function sanitize(Module_PM $module)
	{
		if (false === ($this->pm = GWF_PM::getByID(Common::getGet('pmid')))) {
			return $module->error('err_pm');
		}
		if ($this->pm->isRead()) {
			return $module->error('err_pm_read');
		}
		if (false === $this->pm->canEdit(GWF_Session::getUser())) {
			return $module->error('err_perm_write');
		}
		return false;
	}
	
	private function getForm(Module_PM $module)
	{
		$buttons = array(
			'preview' => $module->lang('btn_preview'),
			'edit' => $module->lang('btn_edit'),
		);
		$data = array(
			'title' => array(GWF_Form::STRING, $this->pm->getVar('pm_title'), $module->lang('th_pm_title')),
			'message' => array(GWF_Form::MESSAGE, $this->pm->getVar('pm_message'), $module->lang('th_pm_message')),
			'cmds' => array(GWF_Form::SUBMITS, $buttons),
		);
		return new GWF_Form($this, $data);
	}

	private function templateEdit(Module_PM $module, $preview='')
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_edit')),
			'preview' => $preview,
		);
		return $module->template('edit.tpl', $tVars);
	}
	
	private function onPreview(Module_PM $module)
	{
		$form = $this->getForm($module);
		$errors = $form->validate($module);
		$preview = $this->templatePreview($module, $form);
		return $errors.$this->templateEdit($module, $preview);
	}
	
	private function templatePreview(Module_PM $module, GWF_Form $form)
	{
		$tVars = array(
			'pm' => GWF_PM::fakePM($this->pm->getSender()->getID(), $this->pm->getReceiver()->getID(), $form->getVar('title'), $form->getVar('message')),
			'actions' => false,
			'title' => $module->lang('ft_preview'),
			'unread' => array(),
		);
		return $module->templatePHP('show.php', $tVars);
	}

	private function onEdit(Module_PM $module)
	{
		$form = $this->getForm($module);
		if (false !== ($errors = $form->validate($module))) {
			return $errors.$this->templateEdit($module);
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
		
		return $module->message('msg_edited').$module->requestMethodB('Overview');
	}
	
	public function validate_title(Module_PM $module, $arg) { return $module->validate_title($arg); }
	public function validate_message(Module_PM $module, $arg) { return $module->validate_message($arg); }
}

?>
