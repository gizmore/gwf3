<?php
/**
 * Trigger cronjob manually for debugging purposes.
 * @author gizmore
 * @since GWF2
 */
final class Admin_Cronjob extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function execute()
	{
		return $this->_module->templateNav().$this->templateCronjob($this->_module);
	}
	
	private function templateCronjob()
	{
		$tVars = array(
			'cron_output' => $this->onCronjob($this->_module),
		);
		return $this->_module->template('cronjob.tpl', $tVars);
	}
	
	private function onCronjob()
	{
		ob_start();
		GWF_ModuleLoader::cronjobs();
		$back = ob_get_contents();
		ob_end_clean();
		return $back;
	}
}
?>
