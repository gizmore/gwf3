<?php
/**
 * Set or remove the superuser password.
 * Provide an empty password to remove it entirely.
 * @author gizmore
 */
final class Admin_SetPass extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function execute()
	{
		$nav = $this->module->templateNav();
	
		if (Common::getPost('setup') !== false)
		{
			return $nav.$this->onSetup();
		}

		return $nav.$this->templateSetup();
	}

	#############
	### Setup ###
	#############
	public function validate_new_pass()
	{
		return false;
	}
	
	public function getFormSetup()
	{
		$data = array(
				'new_pass' => array(GWF_Form::STRING, '', $this->module->lang('th_new_pass')),
				'setup' => array(GWF_Form::SUBMIT, $this->module->lang('btn_setup'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templateSetup()
	{
		$form = $this->getFormSetup();
		$tVars = array(
				'form' => $form->templateY($this->module->lang('ft_setup')),
		);
		return $this->module->templatePHP('setup.php', $tVars);
	}
	
	public function onSetup()
	{
		$form = $this->getFormSetup();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error.$this->templatePrompt();
		}
	
		$plain = $newpass = $form->getVar('new_pass');
		if ($newpass !== '')
		{
			$newpass = GWF_Password::hashPasswordS($newpass);
		}
		$this->module->cfgSaveSuperhash($newpass);
	
		$key = $newpass === '' ? 'msg_pass_cleared' : 'msg_pass_set';
		return $this->module->message($key, array($plain));
	}
}
?>
