<?php
/**
 * Forum Options.
 * @author gizmore
 */
final class Forum_Options extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^forum/options/?$ index.php?mo=Forum&me=Options'.PHP_EOL;
	}
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'forum/options',
						'page_title' => 'Forum options',
						'page_meta_desc' => 'Browse or change forum options',
				),
		);
	}
	
	public function execute()
	{
		if (false !== Common::getPost('change')) {
			return $this->onChange().$this->templateOptions();
		}
		return $this->templateOptions();
	}
	
	private function getForm()
	{
		$user = GWF_Session::getUser();
		$row = GWF_ForumOptions::getUserOptions($user);
		$data = array(
			'subscr' => array(GWF_Form::SELECT, $row->getSubscrSelect($this->module, 'subscr'), $this->module->lang('th_subscr')),
			'hide_subscr' => array(GWF_Form::CHECKBOX, $row->isSubscrHidden(), $this->module->lang('th_hide_subscr')),
			'signature' => array(GWF_Form::MESSAGE, $row->getVar('fopt_signature'), $this->module->lang('th_sig')),
			'change' => array(GWF_Form::SUBMIT, $this->module->lang('btn_change'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateOptions()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_options')),
			'href_subscr' => $this->module->getMethodURL('Subscriptions'),
		);
		return $this->module->template('options.tpl', $tVars);
	}
	
	private function onChange()
	{
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->module))) {
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
		return $this->module->message('msg_options_changed');
	}
	
	##################
	### Validators ###
	##################
	public function validate_signature(Module_Forum $module, $arg) { return $this->module->validate_signature($arg); }
	public function validate_subscr(Module_Forum $module, $arg)
	{
		if (!GWF_ForumOptions::isValidSubscr($arg)) {
			return $this->module->lang('err_subscr_mode');
		}
		if ($arg !== 'none' && !GWF_Session::getUser()->hasValidMail()) {
			return $this->module->lang('err_no_valid_mail');
		}
		return false;
	}
}
?>