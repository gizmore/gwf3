<?php

final class Admin_BaseCFG extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false !== Common::getPost('gpg_create')) {
			return $this->onGPGSig($this->_module).$this->templateBase($this->_module);
		}
		return $this->templateBase($this->_module);
	}
	
	private function templateBase()
	{
		$form = $this->formGPGSig($this->_module);
		$tVars = array(
			'form_gpg' => $form->templateY($this->_module->lang('ft_gpg')),
		);
		return $this->_module->template('base_cfg.php', $tVars);
	}
	
	###########
	### GPG ###
	###########
	private $gpg_fingerprint = false; 
	public function validate_gpg_paste(Module_Admin $module, $arg)
	{
		if (false === ($this->gpg_fingerprint = GWF_PublicKey::grabFingerprint($arg))) {
			return $this->_module->lang('err_gpg_key');
		}
		return false;
	}
	
	private function formGPGSig()
	{
		$data = array(
			'gpg_paste' =>  array(GWF_Form::MESSAGE_NOBB, '', $this->_module->lang('th_gpg_key')),
			'gpg_create' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_gpg_key')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onGPGSig()
	{
		$form = $this->formGPGSig($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error;
		}
		
		return $this->_module->message('msg_gpg_key', array($this->gpg_fingerprint));
	}
}

?>