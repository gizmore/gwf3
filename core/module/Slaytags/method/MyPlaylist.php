<?php
final class Slaytags_MyPlaylist extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		return $this->templateMyPlaylist($this->_module);
	}
	
	private function templateMyPlaylist()
	{
		$tVars = array(
		);
		return $this->_module->template('myplaylist.tpl', $tVars);
	}
}
?>