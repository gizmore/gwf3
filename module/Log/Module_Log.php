<?php
/**
 * Log Member IPs. Search Logfiles.
 * @author gizmore
 * @version 3.0
 * @since 1.0
 */
final class Module_Log extends GWF_Module
{
	public function getVersion() { return 3.00; }
//	public function getDefaultAutoLoad() { return true; }
	public function getClasses() { return array('GWF_LogIP'); }
	public function onInstall($dropTable) { require_once 'GWF_LogInstall.php';}
	public function cfgLogIPs() { return $this->getModuleVar('log_member_ips', '1') === '1'; }
//	public function onStartup()
//	{
//		if ($this->cfgLogIPs())
//		{
//			require_once 'module/Log/GWF_LogIP.php';
//			GWF_LogIP::logIP();
//		}
//	}
}
?>