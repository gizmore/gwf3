<?php
/**
 * This module is the SpaceFramework::init.
 * It's the API to communicate to all SF-Classes.
 * @author SpaceOne
 * @copyright Florian Best
 * @version 1.01
 * @since 10.05.2011
 * @visit www.florianbest.de
 * @license none
 */
final class Module_SF extends GWF_Module
{
	public function getVersion() { return 1.01; }
	public function getDefaultPriority() { return 50; }
	public function getDefaultAutoLoad() { return defined('GWF_SF') ? true : false; }
	public function getClasses() { 
		$classes = array(); 
//		if($this->cfgShellIsEnabled()) {
//			$classes[] = 'SF_Shellfunctions';
//		}
		return $classes;
	}
	public function onLoadLanguage() { return $this->loadLanguage('lang/SF'); }
	public function getAdminSectionURL() { return $this->getMethodURL('Config'); }
	public function getShellPath() { return htmlspecialchars($_SERVER['SCRIPT_NAME']); }
	public function onStartup() { 
		if(defined('GWF_SF')) {
			$this->onInclude();
		}
	}
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'shell_is_enabled' => array('1', 'bool'),
		));
	}
	##############
	### Config ###
	##############
	public function cfgShellIsEnabled() { return $this->getModuleVarBool('shell_is_enabled', '1'); }
}

?>