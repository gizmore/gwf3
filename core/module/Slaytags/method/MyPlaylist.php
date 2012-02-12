<?php
final class Slaytags_MyPlaylist extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		return $this->templateMyPlaylist();
	}
	
	private function templateMyPlaylist()
	{
		$tVars = array(
		);
		return $this->module->template('myplaylist.tpl', $tVars);
	}
}
?>