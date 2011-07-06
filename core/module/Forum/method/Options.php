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
			return $this->onChange($module).$this->templateOptions($module);
		}
		return $this->templateOptions($module);
	}
	
	private function getForm(Module_Forum $module)
	{
		$user = GWF_Session::getUser();
		$row = GWF_ForumOptions::getUserOptions($user);
		$data = array(
			'subscr' => array(GWF_Form::SELECT, $row->getSubscrSelect($module, 'subscr'), $module->lang('th_subscr')),
			'hide_subscr' => array(GWF_Form::CHECKBOX, $row->isSubscrHidden(), $module->lang('th_hide_subscr')),
			'signature' => array(GWF_Form::MESSAGE, $row->getVar('fopt_signature'), $module->lang('th_sig')),
			'change' => array(GWF_Form::SUBMIT, $module->lang('btn_change'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateOptions(Module_Forum $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_options')),
		);
		return $module->templatePHP('options.php', $tVars);
	}
	
	private function onChange(Module_Forum $module)
	{
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
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
		return $module->message('msg_options_changed');
	}
	
	##################
	### Validators ###
	##################
	public function validate_signature(Module_Forum $module, $arg) { return $module->validate_signature($arg); }
	public function validate_subscr(Module_Forum $module, $arg)
	{
		if (!GWF_ForumOptions::isValidSubscr($arg)) {
			return $module->lang('err_subscr_mode');
		}
		if ($arg !== 'none' && !GWF_Session::getUser()->hasValidMail()) {
			return $module->lang('err_no_valid_mail');
		}
		return false;
	}
}
?>