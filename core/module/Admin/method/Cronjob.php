<?php
/**
 * Trigger cronjob manually for debugging purposes.
 * @author gizmore
 * @since GWF2
 */
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
		return $module->template('cronjob.tpl', $tVars);
	}
	
	private function onCronjob(Module_Admin $module)
	{
		ob_start();
		GWF_ModuleLoader::cronjobs();
		$back = ob_get_contents();
		ob_end_clean();
		return $back;
	}
}
?>
