<?php
/**
 * @author SpaceOne
 * @since 10.05.2011
 * @visit www.florianbest.de
 */
final class Module_SF extends GWF_Module
{
	public function getVersion() { return 1.04; }
	public function getDefaultPriority() { return 50; }
	public function getDefaultAutoLoad() { return defined('GWF_SF'); }
	public function getClasses() { 
		$classes = array(); 
//		if($this->cfgShellEnabled()) {
//			$classes[] = 'SF_Shellfunctions';
//		}
		return $classes;
	}
	public function getShellPath() { return htmlspecialchars($_SERVER['SCRIPT_NAME']); }
	public function onStartup() { if(defined('GWF_SF')) $this->onInclude(); }
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'shell_enabled' => array('1', 'bool'),
			'debug_enabled' => array('0', 'bool'),
		));
	}

	public function cfgShellEnabled() { return $this->getModuleVarBool('shell_enabled', '1'); }
	public function cfgDebugEnabled() { return $this->getModuleVarBool('debug_enabled', '0'); }
}

?>
