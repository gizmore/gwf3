<?php
function Upgrade_GWF_3_05(Module_GWF $module)
{
	echo GWF_HTML::message('GWF', 'Triggering Upgrade_GWF_3_05');
	echo GWF_HTML::message('GWF', 'The module_name column got a unique index.');
	$db = gdo_db();
	$modules = GWF_TABLE_PREFIX.'module';
	
//	$query = "ALTER TABLE `$modules` DROP INDEX `module_name` ";
//	if (false === ($db->queryWrite($query)))
//	{
//		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
//	}
	
	$query = "ALTER TABLE `$modules` ADD UNIQUE INDEX `module_name` ( `module_name` )";
	if (false === ($db->queryWrite($query)))
	{
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	return '';
}
?>
