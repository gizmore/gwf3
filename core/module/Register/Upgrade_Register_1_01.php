<?php
function Upgrade_Register_1_01(Module_Register $module)
{
	echo GWF_HTML::message('GWF', 'Triggering Upgrade_Register_1_01');
	echo GWF_HTML::message('GWF', 'The email field in user activation database is now UTF8.');
	echo GWF_HTML::message('GWF', 'I simply re-created the table!');
	
	if (false === GDO::table('GWF_UserActivation')->createTable(true))
	{
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	return '';
}
?>