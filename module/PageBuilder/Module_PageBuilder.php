<?php
/**
 * Create pages with static content.
 * @author gizmore
 * @version 1.0
 * @since 3.0
 */
final class Module_PageBuilder extends GWF_Module
{
	public function getVersion() { return '1.00'; }
	public function getClasses() { return array('GWF_Page', 'GWF_PageGID', 'GWF_PageTags', 'GWF_PageType'); }
	public function onInstall($dropTable) { require_once 'module/PageBuilder/GWF_PB_Install.php'; return GWF_PB_Install::onInstall($this, $dropTable); }
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/pagebuilder'); }
	public function getDefaultPriority() { return 60; }
	
	public function cfgCommentsPerPage() { return $this->getModuleVar('ipp', '10'); }
	
	public function writeHTA()
	{
		$modules = GWF_ModuleLoader::loadModulesFS();
		foreach ($modules as $i => $module)
		{
			$module instanceof GWF_Module;
			if (!$module->isEnabled())
			{
				unset($modules[$i]);
			}
		}
		
		return GWF_ModuleLoader::installHTAccess($modules);
	}
}
?>