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
	public function getDefaultAutoLoad() { return true; }
	public function getClasses() { return array('SF', 'SF_init', 'SF_Navigation'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/SF'); }
	public function getAdminSectionURL() { return $this->getMethodURL('Config'); }
	public function onStartup() { return $this->onInclude(); }
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'default_layout' => array('space', 'text', '0', '11'),
			'default_design' => array('SF', 'text', '0', '11'),
			'default_color' => array('green', 'text', '0', '11'),
		));
	}
	##############
	### Config ###
	##############
	public function cfgdefaultLayout() { return $this->getModuleVar('default_layout', 'space'); }
	public function cfgdefaultDesign() { return $this->getModuleVar('default_design', 'SF'); }
	public function cfgdefaultColor() { return $this->getModuleVar('default_color', 'green'); }
	public function cfgCookieTime() { return (time()+60*60*24*30); }
}

?>