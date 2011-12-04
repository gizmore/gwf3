<?php
function Upgrade_PageBuilder_1_01(Module_PageBuilder $module)
{
	$db = gdo_db();
	$page = GWF_TABLE_PREFIX.'page';
	$query = "ALTER TABLE $page DROP COLUMN `page_menu_pos`";
	$addcol = "ALTER TABLE $page ADD COLUMN `page_inline_css` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL";
	if (false === ($db->queryWrite($query)) || false === ($db->queryWrite($addcol))) {
		return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	}

}
