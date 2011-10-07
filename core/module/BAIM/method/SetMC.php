<?php
final class BAIM_SetMC extends GWF_Method
{
	private $row = false;
	
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($this->row = BAIM_MC::getByUID(GWF_Session::getUserID()))) {
			return $module->error('err_not_purchased');
		}
		
		if ($this->row->isDemo()) {
			return $module->error('err_not_purchased');
		}
		
//		var_dump($this->row);
		
		$back = '';
		if (false !== Common::getPost('set')) {
			$back = $this->onSetMC($module, $this->row);
		}
		
		return $back.$this->templateMC($module, $this->row);
	}
	
	private function formMC(Module_BAIM $module, BAIM_MC $row)
	{
		$data = array(
//			'mc' => array(GWF_Form::STRING, $row->getMC(), $module->lang('th_mc'), $module->lang('tt_mc')),
			'mc' => array(GWF_Form::VALIDATOR),
			'set' => array(GWF_Form::SUBMIT, $module->lang('menu_mc')),
		);
		return new GWF_Form($this, $data);
	}

	private function templateMC(Module_BAIM $module, BAIM_MC $row)
	{
		$form = $this->formMC($module, $row);
		$tVars = array(
			'row' => $row,
			'form' => $form->templateY($module->lang('ft_set_mc')),
		);
		return $module->templatePHP('set_mc.php', $tVars);
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
		$form = $this->formMC($module, $row);
		if (false !== ($errors = $form->validate($module))) {
			return $errors;
		}
		
//		$mc = $_POST['mc'];
		if (false === $row->changeMC(NULL)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $module->message('msg_set_mc');#, GWF_HTML::display($mc));
	}
}
?>