<?php
/**
 * Forum Options.
 * @author gizmore
 */
final class Forum_Options extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^forum/options/?$ index.php?mo=Forum&me=Options'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== Common::getPost('change')) {
			return $this->onChange($this->_module).$this->templateOptions($this->_module);
		}
		return $this->templateOptions($this->_module);
	}
	
	private function getForm(Module_Forum $module)
	{
		$user = GWF_Session::getUser();
		$row = GWF_ForumOptions::getUserOptions($user);
		$data = array(
			'subscr' => array(GWF_Form::SELECT, $row->getSubscrSelect($this->_module, 'subscr'), $this->_module->lang('th_subscr')),
			'hide_subscr' => array(GWF_Form::CHECKBOX, $row->isSubscrHidden(), $this->_module->lang('th_hide_subscr')),
			'signature' => array(GWF_Form::MESSAGE, $row->getVar('fopt_signature'), $this->_module->lang('th_sig')),
			'change' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_change'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateOptions(Module_Forum $module)
	{
		$form = $this->getForm($this->_module);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_options')),
			'href_subscr' => $this->_module->getMethodURL('Subscriptions'),
		);
		return $this->_module->template('options.tpl', $tVars);
	}
	
	private function onChange(Module_Forum $module)
	{
		$form = $this->getForm($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error;
		}
		$row = GWF_ForumOptions::getUserOptionsS();
		$options = isset($_POST['hide_subscr']) ? GWF_ForumOptions::HIDE_SUBSCR : 0;
		$data = array(
			'fopt_subscr' => $form->getVar('subscr'),
			'fopt_options' => $options,
			'fopt_signature' => $form->getVar('signature'),
		);
		if (false === $row->saveVars($data)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return $this->_module->message('msg_options_changed');
	}
	
	##################
	### Validators ###
	##################
	public function validate_signature(Module_Forum $module, $arg) { return $this->_module->validate_signature($arg); }
	public function validate_subscr(Module_Forum $module, $arg)
	{
		if (!GWF_ForumOptions::isValidSubscr($arg)) {
			return $this->_module->lang('err_subscr_mode');
		}
		if ($arg !== 'none' && !GWF_Session::getUser()->hasValidMail()) {
			return $this->_module->lang('err_no_valid_mail');
		}
		return false;
	}
}
?>