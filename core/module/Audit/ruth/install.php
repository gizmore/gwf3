<?php
require_once '../bootstrap.php';
require_once GWF_CORE_PATH.'module/Audit/GWF_AuditAddUser.php';
if (false === GDO::table('GWF_AuditAddUser')->createTable(false))
{
	echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
}

?>