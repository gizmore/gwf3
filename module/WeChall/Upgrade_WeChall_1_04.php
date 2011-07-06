<?php
function Upgrade_WeChall_1_04(Module_WeChall $module)
{
	$db = gdo_db();
	$sites = GWF_TABLE_PREFIX.'wc_site';
	$query = "ALTER TABLE $sites ADD COLUMN site_descr_lid INT(11) UNSIGNED NOT NULL DEFAULT 1";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	
	require_once 'core/module/WeChall/WC_SiteDescr.php';
	if (false === GDO::table('WC_SiteDescr')->createTable(true)) {
		return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	
	$patches = array(
		13 => 5, # Yashira => Spanish
		43 => 3, # HackBBS => French
		17 => 5, # Hispabyte => Spanish
	);
	
	foreach (WC_Site::getSites('site_id ASC') as $site)
	{
		$site instanceof WC_Site;
		
		$siteid = $site->getID();
		
		$desc = $site->getVar('site_description');
		
		if (isset($patches[$siteid])) {
			$langid = $patches[$siteid];
		} else {
			$langid = 1;
		}
		if (false === WC_SiteDescr::insertDescr($siteid, $langid, $desc)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		if (false === $site->saveVar('site_descr_lid', $langid)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
	}
	
	$query = "ALTER TABLE `$sites` DROP `site_description`";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	}

	GWF_HTML::message('WC', '[+] Multi Lang Descriptions', true, true);
	
	return '';
}
?>