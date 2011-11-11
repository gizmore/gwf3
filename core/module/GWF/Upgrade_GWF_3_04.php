<?php
function Upgrade_GWF_3_04(Module_GWF $module)
{
	echo GWF_HTML::message('GWF', 'Triggering Upgrade_GWF_3_04');
	echo GWF_HTML::message('GWF', 'The email field in user database is now UTF8.');
	$db = gdo_db();
	$users = GWF_TABLE_PREFIX.'user';
	$query = "ALTER TABLE `{$users}` CHANGE `user_email` `user_email` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL";
	if (false === ($db->queryWrite($query)))
	{
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	
	$modules = GWF_TABLE_PREFIX.'module';
	$query = "ALTER TABLE `$modules` ADD UNIQUE `module_name` ( `module_name` )";
	
	return '';
}
?>