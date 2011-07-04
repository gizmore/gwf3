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
	$query = 'SELECT page_content c FROM '.GWF_TABLE_PREFIX.'page WHERE page_id='.((int)$tpl_name);
	if (false === ($result = gdo_db()->queryFirst($query)))
	{
		$tpl_source = GWF_HTML::err(ERR_DATABASE, array(__FILE__, __LINE__));
		return false;
	}
	$tpl_source = $result['c'];
	return true;
	
	
//	$query = 'SELECT page_content c, page_options o, page_author_name author, page_date pd, page_create_date pcd, page_id pid, page_otherid oid FROM '.GWF_TABLE_PREFIX.'page WHERE page_id='.((int)$tpl_name);
//	if (false === ($result = gdo_db()->queryFirst($query))) {
//		$tpl_source = GWF_HTML::err(ERR_DATABASE, array(__FILE__, __LINE__));
//		return false;
//	}
//	
//	$tpl_source = '<div class="pb_content">'.$result['c'].'</div>';
//	
//	$options = (int)$result['o'];
//	
//	$module = GWF_Module::getModule('PageBuilder');
//	
//	$meta = '';
//	if ($options & GWF_Page::SHOW_AUTHOR) {
//		$meta .= '<p class="pb_author">'.$module->lang('info_author', array(htmlspecialchars($result['author']))).'</p>';
//	}
//	if ($options & GWF_Page::SHOW_MODIFIED) {
//		$meta .= '<p class="pb_modified">'.$module->lang('info_modified', array(GWF_Time::displayDate($result['pcd']), GWF_Time::displayDate($result['pd']), GWF_Time::displayAge($result['pd']))).'</p>';
//	}
//	if ($options & GWF_Page::SHOW_SIMILAR) {
//		$meta .= smartyPBSimilar($module, $result);
//	}
//	if ($options & GWF_Page::SHOW_TRANS) {
//		$meta .= smartyPBTranslations($module, $result);
//	}
//	
//	if ($meta !== '') {
//		$tpl_source .= '<div class="pb_meta">'.$meta.'</div>';
//	}
//	
//    return true;
}

# Trigger recompile?
function smarty_resource_db_timestamp($tpl_name, &$tpl_timestamp, $smarty)
{
	$query = 'SELECT page_time t FROM '.GWF_TABLE_PREFIX.'page WHERE page_id='.((int)$tpl_name);
	if (false === ($result = gdo_db()->queryFirst($query)))
	{
    	$tpl_timestamp = time();
		return false;
	}
	$tpl_timestamp = time();
//	$tpl_timestamp = $result['t'];
	return true;
}

# Not needed
function smarty_resource_db_secure($tpl_name, &$smarty) { return true; }
function smarty_resource_db_trusted($tpl_name, &$smarty) {}

### source
//function smartyPBSimilar(Module_PageBuilder $module, array $result)
//{
//	$db = gdo_db();
//	$query = 'SELECT page_title, page_url, page_lang FROM '.GWF_TABLE_PREFIX.'page WHERE page_otherid='.$result['oid'].' AND page_id!='.$result['pid'];
//	
//	return '';
//}
//
///**
// * Show translations for this page.
// * @param $module
// * @param $result
// */
//function smartyPBTranslations(Module_PageBuilder $module, array $result)
//{
//	$db = gdo_db();
//	$query = 'SELECT page_title, page_url, page_lang FROM '.GWF_TABLE_PREFIX.'page WHERE page_otherid='.$result['oid'].' AND page_id!='.$result['pid'];
//	if (false === ($result = $db->queryRead($query))) {
//		return '';
//	}
//	
//	$back = '';
//	
//	while (false !== ($row = $db->fetchRow($result)))
//	{
//		if (false === ($lang = GWF_Language::getByID($row[2]))) {
//			continue;
//		}
//		$iso = $lang->getVar('lang_iso');
//		$back .= sprintf('<a href="%s%s/%s" title="%s">%s</a>', GWF_WEB_ROOT_NO_LANG, $iso, htmlspecialchars($row[1]), htmlspecialchars($row[0]), $iso);
//	}
//	
//	$db->free($result);
//	
//	return $back === '' ? '' : '<p class="pb_translations">'.$module->lang('info_trans', array($back)).'</p>';
//}
?>
