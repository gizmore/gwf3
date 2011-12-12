<?php
require_once 'ViewLog.php';

final class Audit_Replay extends Audit_ViewLog
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^warplay/([^/_]+)_([^/_]+)_(\\d+)_([a-zA-Z0-9]+)\.html$ index.php?mo=Audit&me=Replay&user=$1&euser=$2&id=$3&token=$4'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($module)))
		{
			return $error;
		}
		return $this->templateReplay($module, $this->log);
	}
	
	public function templateReplay(Module_Audit $module, GWF_AuditLog $log)
	{
		GWF_Website::addJavascriptInline('var al_script='.$log->getAjaxScript().';');
		GWF_Website::addJavascriptInline('var al_times='.$log->getAjaxTimes().';');
		GWF_Website::addJavascriptOnload('alReplay();');
		
		$tVars = array(
			'log' => $log,
		);
		return $module->template('replay.tpl', $tVars);
	}
}
?>