<?php

final class Admin_BaseCFG extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false !== Common::getPost('gpg_create')) {
			return $this->onGPGSig($module).$this->templateBase($module);
		}
		return $this->templateBase($module);
	}
	
	private function templateBase(Module_Admin $module)
	{
		$form = $this->formGPGSig($module);
		$tVars = array(
			'form_gpg' => $form->templateY($module->lang('ft_gpg')),
		);
		return $module->template('base_cfg.php', $tVars);
	}
	
	###########
	### GPG ###
	###########
	private $gpg_fingerprint = false; 
	public function validate_gpg_paste(Module_Admin $module, $arg)
	{
		if (false === ($this->gpg_fingerprint = GWF_PublicKey::grabFingerprint($arg))) {
			return $module->lang('err_gpg_key');
		}
		return false;
	}
	
	private function formGPGSig(Module_Admin $module)
	{
		$data = array(
			'gpg_paste' =>  array(GWF_Form::MESSAGE_NOBB, '', $module->lang('th_gpg_key')),
			'gpg_create' => array(GWF_Form::SUBMIT, $module->lang('btn_gpg_key')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onGPGSig(Module_Admin $module)
	{
		$form = $this->formGPGSig($module);
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}
		
		return $module->message('msg_gpg_key', array($this->gpg_fingerprint));
	}
}

?>