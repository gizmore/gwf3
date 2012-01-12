<?php
require_once 'ViewLog.php';

final class Audit_Replay extends Audit_ViewLog
{
	public function getHTAccess()
	{
		return 'RewriteRule ^warplay/([^/_]+)_([^/_]+)_(\\d+)_([a-zA-Z0-9]+)\.html$ index.php?mo=Audit&me=Replay&user=$1&euser=$2&id=$3&token=$4'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize()))
		{
			return $error;
		}
		return $this->templateReplay($this->_module, $this->log);
	}
	
	public function templateReplay(Module_Audit $module, GWF_AuditLog $log)
	{
		GWF_Website::addJavascriptInline('var al_script='.$log->getAjaxScript().';');
		GWF_Website::addJavascriptInline('var al_times='.$log->getAjaxTimes().';');
		GWF_Website::addJavascriptOnload('alReplay();');
		
		$tVars = array(
			'log' => $log,
		);
		return $this->_module->template('replay.tpl', $tVars);
	}
}
?>