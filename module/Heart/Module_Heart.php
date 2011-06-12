<?php
/**
 * Does track the online counter via ajax and browser requests.
 * Also holds userrecords.
 * @author gizmore
 * @version 1.02
 * @since GWF3
 */
final class Module_Heart extends GWF_Module
{
	public function getVersion() { return 1.02; }
	public function getDefaultAutoLoad() { return true; }
	public function onInstall($dropTables) { require_once 'module/Heart/GWF_HeartInstall.php'; GWF_HeartInstall::onInstall($this, $dropTables); }
	public function onStartup()
	{
		$ms = (string)((GWF_ONLINE_TIMEOUT-3)*1000);
		GWF_Website::addJavascriptInline(sprintf('setTimeout("gwf_heartbeat(%s);", %s);', $ms, $ms));
		GWF_Website::addJavascript($this->getModuleFilePath('js/hb.js'));
		
		
		
		$pc = $this->cfgPagecount();
		$this->saveModuleVar('hb_pagecount', $pc+1);
	}
	
	public function cfgPagecount() { return $this->getModuleVar('hb_pagecount', '0'); }
	public function cfgUserrecordDate() { return $this->getModuleVar('hb_recorddate', '0'); }
	public function cfgUserrecordCount() { return $this->getModuleVar('hb_userrecord', '00000000000000'); }
}
?>