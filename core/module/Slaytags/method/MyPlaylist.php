<?php
final class Slaytags_MyPlaylist extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		return $this->templateMyPlaylist($module);
	}
	
	private function templateMyPlaylist(Module_Slaytags $module)
	{
		$tVars = array(
		);
		return $module->template('myplaylist.tpl', $tVars);
	}
}
?>