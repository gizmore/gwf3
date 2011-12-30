<?php
/**
 * Create pages with static content.
 * @author gizmore, spaceone
 * @version 1.01
 * @since 3.0
 */
final class Module_PageBuilder extends GWF_Module
{
	public function getVersion() { return '1.02'; }
	public function getClasses() { return array('GWF_Page', 'GWF_PageGID', 'GWF_PageTags', 'GWF_PageType'); }
	public function onInstall($dropTable) { require_once 'GWF_PB_Install.php'; return GWF_PB_Install::onInstall($this, $dropTable); }
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/pagebuilder'); }
	public function getDefaultPriority() { return 60; }
	
	public function cfgCommentsPerPage() { return $this->getModuleVarInt('ipp', '10'); }
	public function cfgHomePage() { return $this->getModuleVarInt('home_page', '0'); }
	public function setHomePage($pageid) { $this->saveModuleVar('home_page', $pageid); }
	
	public function writeHTA()
	{
		return GWF_ModuleLoader::reinstallHTAccess();
	}
}
?>
