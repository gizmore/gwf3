<?php
class Audit_ViewLog extends GWF_Method
{
	protected $log = NULL;
	
	public function getHTAccess()
	{
		return 'RewriteRule ^warscript/([^/_]+)_([^/_]+)_(\\d+)_([a-zA-Z0-9]+)\.html$ index.php?mo=Audit&me=ViewLog&euser=$1&user=$2&id=$3&token=$4'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize()))
		{
			return $error;
		}
		return $this->templateViewLog($this->log);
	}
	
	public function sanitize()
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
		
		if (false !== ($error = $this->validateAccess($eusername, $id, $rand)))
		{
			return $error;
		}
		return false;
	}
	
	public function validateAccess($eusername, $id, $rand)
	{
		if (false === ($log = GWF_AuditLog::getByID($id)))
		{
			return $this->_module->error('err_log');
		}
		
		if ( ($log->getVar('al_eusername') !== $eusername) || ($log->getVar('al_rand') !== $rand) )
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		$this->log = $log;
		
		return false;
	}
	
	private function templateViewLog(GWF_AuditLog $log)
	{
		$tVars = array(
			'log' => $log,
		);
		return $this->_module->template('log.tpl', $tVars);
	}
}
?>