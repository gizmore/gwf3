<?php

final class Admin_Cronjob extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function execute(GWF_Module $module)
	{
		return $module->templateNav().$this->templateCronjob($module);
	}
	
	private function templateCronjob(Module_Admin $module)
	{
		$tVars = array(
			'cron_output' => $this->onCronjob($module),
		);
		return $module->templatePHP('cronjob.php', $tVars);
	}
	
	private function onCronjob(Module_Admin $module)
	{
//		GWF_Logger::$ECHO_CRONJOBS = true;
		
//		if (false !== ($logger = GWF_Module::getModule('Logger'))) {
//			$logger->triggerRotation();
//		}
		
		return GWF_ModuleLoader::cronjobs();
//		return GWF_Website::cronjobs();
//		return GWF_Website::captureEcho(array('GWF_Website', 'cronjobs'));
	}
	
}

?>