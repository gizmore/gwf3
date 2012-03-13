<?php
final class Admin_BaseCFG extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function execute()
	{
		if (false !== Common::getPost('gpg_create')) {
			return $this->onGPGSig().$this->templateBase();
		}
		return $this->templateBase();
	}
	
	private function templateBase()
	{
		$form = $this->formGPGSig();
		$tVars = array(
			'form_gpg' => $form->templateY($this->module->lang('ft_gpg')),
		);
		return $this->module->template('base_cfg.php', $tVars);
	}
	
	###########
	### GPG ###
	###########
	private $gpg_fingerprint = false; 
	public function validate_gpg_paste(Module_Admin $module, $arg)
	{
		if (false === ($this->gpg_fingerprint = GWF_PublicKey::grabFingerprint($arg))) {
			return $this->module->lang('err_gpg_key');
		}
		return false;
	}
	
	private function formGPGSig()
	{
		$data = array(
			'gpg_paste' =>  array(GWF_Form::MESSAGE_NOBB, '', $this->module->lang('th_gpg_key')),
			'gpg_create' => array(GWF_Form::SUBMIT, $this->module->lang('btn_gpg_key')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onGPGSig()
	{
		$form = $this->formGPGSig();
		if (false !== ($error = $form->validate($this->module))) {
			return $error;
		}
		
		return $this->module->message('msg_gpg_key', array($this->gpg_fingerprint));
	}
}

?>