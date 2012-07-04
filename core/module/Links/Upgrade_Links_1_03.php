<?php
function Upgrade_Links_1_03(Module_Links $module)
{
	echo GWF_HTML::message('Links', 'Langauge filter');
	
	$db = gdo_db();
	$table = GWF_TABLE_PREFIX.'links';
	
	$query = "ALTER TABLE {$table} ADD COLUMN link_lang INT(11) UNSIGNED NOT NULL DEFAULT 1";
	if (false === $db->queryWrite($query))
	{
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	
	$query = "ALTER TABLE {$table} ADD INDEX(link_lang)";
	if (false === $db->queryWrite($query))
	{
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	
	return '';
}
?>
