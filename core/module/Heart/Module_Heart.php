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
	public function onInstall($dropTables) { require_once 'GWF_HeartInstall.php'; GWF_HeartInstall::onInstall($this, $dropTables); }
	public function onStartup()
	{
		$ms = (string)((GWF_ONLINE_TIMEOUT/2-1)*1000);
		
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/module/Heart/hb.js');
		GWF_Website::addJavascriptOnload(sprintf('setTimeout("gwf_heartbeat(%s);", %s);', $ms, $ms));
		
		$cut = time() - GWF_ONLINE_TIMEOUT;
		$spider = GWF_User::WEBSPIDER;
		$online = GDO::table('GWF_User')->selectVar('COUNT(*)', "user_lastactivity>{$cut} AND user_options&{$spider}=0");
		
		if ($online > $this->cfgUserrecordCount())
		{
			$this->saveModuleVar('hb_userrecord', $online);
			$this->saveModuleVar('hb_recorddate', GWF_Time::getDate(14));
		}
		
		$pc = $this->cfgPagecount();
		$this->saveModuleVar('hb_pagecount', $pc+1);
	}
	
	public function cfgPagecount() { return $this->getModuleVar('hb_pagecount', '0'); }
	public function cfgUserrecordCount() { return $this->getModuleVar('hb_userrecord', '0'); }
	public function cfgUserrecordDate() { return $this->getModuleVar('hb_recorddate', '00000000000000'); }
}
?>