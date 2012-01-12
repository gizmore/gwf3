<?php
final class BAIM_Admin extends GWF_Method
{
	private $user;
	
	public function getUserGroups() { return 'admin'; }
	
	public function execute()
	{
		if (false !== Common::getPost('newdemo')) {
			return $this->onNewDemo($this->_module).$this->templateAdmin($this->_module);
		}
		if (false !== Common::getPost('flushdemo')) {
			return $this->onFlushDemo($this->_module).$this->templateAdmin($this->_module);
		}
		return $this->templateAdmin($this->_module);
	}
	
	private function templateAdmin()
	{
		$form_flush = $this->formFlushDemo($this->_module);
		$form_new_demo = $this->formNewDemo($this->_module);
		$tVars = array(
			'form_flush' => $form_flush->templateY($this->_module->lang('ft_flush_demo')),
			'form_new_demo' => $form_new_demo->templateY($this->_module->lang('ft_new_demo')),
		);
		return $this->_module->templatePHP('admin.php', $tVars);
	}
	
	### More Demo
	private function formNewDemo()
	{
		$data = array(
			'username' => array(GWF_Form::STRING, '', $this->_module->lang('th_user_name')),
			'newdemo' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_new_demo')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_username($m, $arg)
	{
		if (false === ($this->user = GWF_User::getByName($arg))) {
			return GWF_HTML::lang('ERR_UNKNOWN_USER');
		}
		return false;
	}
	
	private function onNewDemo()
	{
		$form_new_demo = $this->formNewDemo($this->_module);
		if (false !== ($error = $form_new_demo->validate($this->_module))) {
			return $error;
		}
		$table = GDO::table('BAIM_MC');
		$userid = $this->user->getID();
		if (false === ($mc = BAIM_MC::getByUID($userid))) {
			return $this->_module->error('err_no_mc');
		}
		$emc = $mc->getMC();
		$emc = $table->escape($emc);
		$count = $table->countRows("bmc_mc='$emc'");
		
		if ($count > 1) {
			return $this->_module->error('err_mc_cheater');
		}
		
		elseif ($count === 0) {
			return $this->_module->error('err_no_mc_set');
		}
		
		if (false === $mc->delete()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		return $this->_module->message('msg_new_demo', array($this->user->displayUsername()));
	}
	
	### Flush all demo
	private function formFlushDemo()
	{
		$data = array(
			'flushdemo' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_flush_demo')),
		);
		return new GWF_Form($this, $data);
	}
	
}
?>