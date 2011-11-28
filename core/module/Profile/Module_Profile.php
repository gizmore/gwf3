<?php
/**
 * User Profiles.
 * @author gizmore
 * @version 1.0
 */
final class Module_Profile extends GWF_Module
{
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.01; }
	public function getDefaultPriority() { return 40; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/profile'); }
	public function getClasses() { return array('GWF_Profile', 'GWF_ProfileLink'); }
	public function onInstall($dropTable) { require_once 'GWF_ProfileInstall.php'; return GWF_ProfileInstall::onInstall($this, $dropTable); }
	
	##############
	### Config ###
	##############
	public function cfgAllowHide() { return $this->getModuleVarBool('prof_hide', '1'); }
	public function cfgMaxAboutLen() { return $this->getModuleVarInt('prof_max_about', 512); }
	public function cfgLevelGB() { return $this->getModuleVarInt('prof_level_gb', 0); }
}
?>
