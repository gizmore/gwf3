<?php
final class Module_Heart extends GWF_Module
{
	public function getVersion() { return 1.01; }
	public function getDefaultAutoLoad() { return true; }
	public function onStartup()
	{
		$ms = (string)((GWF_ONLINE_TIMEOUT-3)*1000);
		GWF_Website::addJavascriptInline(sprintf('setTimeout("gwf_heartbeat(%s);", %s);', $ms, $ms));
		GWF_Website::addJavascript($this->getModuleFilePath('js/hb.js'));
	}
}
?>