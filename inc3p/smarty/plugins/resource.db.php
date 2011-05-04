<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     resource.db.php
 * Type:     resource
 * Name:     db
 * Purpose:  Fetches templates from a database. Shows last modified, similar posts, and available languages.
 * Author:   gizmore (GWFv3)
 * -------------------------------------------------------------
 */
function smarty_resource_db_source($tpl_name, &$tpl_source, $smarty)
{
	$query = 'SELECT page_content c, page_options o FROM '.GWF_TABLE_PREFIX.'page WHERE page_id='.((int)$tpl_name);
	if (false === ($result = gdo_db()->queryFirst($query))) {
		$tpl_source = GWF_HTML::err(ERR_DATABASE, array(__FILE__, __LINE__));
		return false;
	}
	$tpl_source = $result['c'];
	$options = (int)$result['o'];
    return true;
}

function smarty_resource_db_timestamp($tpl_name, &$tpl_timestamp, $smarty)
{
	$query = 'SELECT page_time t FROM '.GWF_TABLE_PREFIX.'page WHERE page_id='.((int)$tpl_name);
	if (false === ($result = gdo_db()->queryFirst($query))) {
    	$tpl_timestamp = time();
		return false;
	}
	$tpl_timestamp = (int)$result['t'];
    return true;
}

function smarty_resource_db_secure($tpl_name, &$smarty)
{
    return true;
}

function smarty_resource_db_trusted($tpl_name, &$smarty)
{
}
?>
