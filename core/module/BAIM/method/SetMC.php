<?php
final class BAIM_SetMC extends GWF_Method
{
	private $row = false;
	
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($this->row = BAIM_MC::getByUID(GWF_Session::getUserID()))) {
			return $this->_module->error('err_not_purchased');
		}
		
		if ($this->row->isDemo()) {
			return $this->_module->error('err_not_purchased');
		}
		
//		var_dump($this->row);
		
		$back = '';
		if (false !== Common::getPost('set')) {
			$back = $this->onSetMC($this->_module, $this->row);
		}
		
		return $back.$this->templateMC($this->_module, $this->row);
	}
	
	private function formMC(Module_BAIM $module, BAIM_MC $row)
	{
		$data = array(
//			'mc' => array(GWF_Form::STRING, $row->getMC(), $this->_module->lang('th_mc'), $this->_module->lang('tt_mc')),
			'mc' => array(GWF_Form::VALIDATOR),
			'set' => array(GWF_Form::SUBMIT, $this->_module->lang('menu_mc')),
		);
		return new GWF_Form($this, $data);
	}

	private function templateMC(Module_BAIM $module, BAIM_MC $row)
	{
		$form = $this->formMC($this->_module, $row);
		$tVars = array(
			'row' => $row,
			'form' => $form->templateY($this->_module->lang('ft_set_mc')),
		);
		return $this->_module->templatePHP('set_mc.php', $tVars);
	}
	
	public function validate_mc(Module_BAIM $m, $arg)
	{
//		if (!Baim_MC::isValidMC($arg)) {
//			return $m->lang('err_mc');
//		}
		if (!$this->row->canChange()) {
			return $m->lang('err_change_freq', array($this->row->displayNextChange()));
		}
		return false;
	}
	
	private function onSetMC(Module_BAIM $module, BAIM_MC $row)
	{
		$form = $this->formMC($this->_module, $row);
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors;
		}
		
//		$mc = $_POST['mc'];
		if (false === $row->changeMC(NULL)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_set_mc');#, GWF_HTML::display($mc));
	}
}
?>