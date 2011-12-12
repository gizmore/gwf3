<?php
class Audit_ViewLog extends GWF_Method
{
	protected $log = NULL;
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^warscript/([^/_]+)_([^/_]+)_(\\d+)_([a-zA-Z0-9]+)\.html$ index.php?mo=Audit&me=ViewLog&euser=$1&user=$2&id=$3&token=$4'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($module)))
		{
			return $error;
		}
		return $this->templateViewLog($module, $this->log);
	}
	
	public function sanitize(GWF_Module $module)
	{
		if ('' === ($eusername = Common::getGetString('euser')))
		{
			return GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'euser'));
		}
		if ('' === ($username = Common::getGetString('user')))
		{
			return GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'user'));
		}
		if ('' === ($id = Common::getGetString('id')))
		{
			return GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'id'));
		}
		if ('' === ($rand = Common::getGetString('token')))
		{
			return GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'token'));
		}
		
		if (false !== ($error = $this->validateAccess($module, $eusername, $id, $rand)))
		{
			return $error;
		}
		return false;
	}
	
	public function validateAccess(Module_Audit $module, $eusername, $id, $rand)
	{
		if (false === ($log = GWF_AuditLog::getByID($id)))
		{
			return $module->error('err_log');
		}
		
		if ( ($log->getVar('al_eusername') !== $eusername) || ($log->getVar('al_rand') !== $rand) )
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		$this->log = $log;
		
		return false;
	}
	
	private function templateViewLog(Module_Audit $module, GWF_AuditLog $log)
	{
		$tVars = array(
			'log' => $log,
		);
		return $module->template('log.tpl', $tVars);
	}
}
?>