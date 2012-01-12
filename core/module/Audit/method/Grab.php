<?php
final class Audit_Grab extends GWF_Method
{
	public function getUserGroups() { return array('staff'); }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^rawscript/(\\d+)\\.log$ index.php?mo=Audit&me=Grab&id=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false === ($id = Common::getGetInt('id', false)))
		{
			return GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'id'));
		}
		if (false === ($log = GWF_AuditLog::getByID($id)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		GWF_Website::plaintext();
		die($log->getVar('al_data'));
	}
}
?>