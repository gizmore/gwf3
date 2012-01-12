<?php
final class Login_History extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		require_once GWF_CORE_PATH.'module/Login/GWF_LoginCleared.php';
		require_once GWF_CORE_PATH.'module/Login/GWF_LoginHistory.php';
		if (false !== Common::getPost('clear')) {
			return $this->onClear($this->_module).$this->templateHistory($this->_module);
		}
		return $this->templateHistory($this->_module);
	}
	
	private function templateHistory(Module_Login $module)
	{
		$userid = GWF_Session::getUser()->getID();
		$history = GDO::table('GWF_LoginHistory');
		$conditions = "loghis_uid=$userid";
		$nItems = $history->countRows($conditions);
		$ipp = 50;
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGet('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$by = Common::getGet('by');
		$dir = Common::getGet('dir');
		$orderby = $history->getMultiOrderby($by, $dir);
		$form = $this->formDelete($this->_module);
		
		$headers = array(
			array($this->_module->lang('th_loghis_time'), 'loghis_time'),
			array($this->_module->lang('th_loghis_ip'), 'loghis_ip'),
			array($this->_module->lang('th_hostname')),
		);
		
		if (false !== ($c = GWF_LoginCleared::getCleared($userid))) {
			$cleared = $this->_module->lang('info_cleared', array($c->displayDate(), $c->displayIP(), $c->displayHost()));
		} else {
			$cleared = '';
		}
		
		
		$tVars = array(
			'tablehead' => GWF_Table::displayHeaders2($headers),
			'history' => $history->selectObjects('*', $conditions, $orderby, $ipp, $from),
//			'sort_url' => $this->_module->getMethodURL('History', '&by=%BY%&dir=%DIR%&page=1'),
			'pagemenu' => GWF_PageMenu::display($page, $nPages, $this->_module->getMethodURL('History', '&by='.urlencode($by).'&dir='.urlencode($dir).'&page=%PAGE%')),
			'form' => $form->templateX($this->_module->lang('ft_clear')),
			'cleared' => $cleared,
		);
		return $this->_module->template('history.tpl', $tVars);
	}
	
	private function formDelete(Module_Login $module)
	{
		$data = array(
			'clear' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_clear')),
		);
		return new GWF_Form($this, $data);
	}

	private function onClear(Module_Login $module)
	{
		$form = $this->formDelete($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error;
		}
		
		$userid = GWF_Session::getUserID();
		
		if (false === GWF_LoginCleared::updateCleared($userid)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === GDO::table('GWF_LoginHistory')->deleteWhere("loghis_uid=$userid")) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_cleared');
	}
}
?>