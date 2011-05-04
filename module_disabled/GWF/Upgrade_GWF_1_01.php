<?php
function Upgrade_GWF_1_01(Module_GWF $module)
{
	var_dump('TRIGGERED Upgrade GWF1.01');
	
	$db = gdo_db();
	# NEW: Module options
	$modules = GWF_TABLE_PREFIX.'module';
	$query = "ALTER TABLE $modules DROP COLUMN module_enabled";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	$query = "ALTER TABLE $modules ADD INDEX module_priority (module_priority)";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	//	$query = "ALTER TABLE $modules ADD COLUMN module_options INT(11) UNSIGNED NOT NULL DEFAULT 1";
//	if (false === $db->queryWrite($query)) {
//		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
//	}
	
	# Change columns in language
	$langs = GWF_TABLE_PREFIX.'language';
	$query = "ALTER TABLE $langs CHANGE COLUMN langid lang_id int(11) unsigned NOT NULL";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	$query = "ALTER TABLE $langs CHANGE COLUMN name lang_name varchar(64) character set ascii NOT NULL";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	$query = "ALTER TABLE $langs CHANGE COLUMN nativename lang_nativename varchar(64) default NULL";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	$query = "ALTER TABLE $langs CHANGE COLUMN short lang_short char(3) character set ascii collate ascii_bin NOT NULL";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	$query = "ALTER TABLE $langs CHANGE COLUMN iso lang_iso char(2) character set ascii collate ascii_bin NOT NULL";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	
	# Change columns in country
	$countries = GWF_TABLE_PREFIX.'country';
	$query = "ALTER TABLE $countries CHANGE COLUMN countryid country_id  int(11) unsigned NOT NULL default '0'";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	$query = "ALTER TABLE $countries CHANGE COLUMN name country_name varchar(63) default NULL";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	$query = "ALTER TABLE $countries CHANGE COLUMN tld country_tld char(2) default NULL";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	
	# Change columns in session
	$session = GWF_TABLE_PREFIX.'session';
	$query = "ALTER TABLE $session DROP COLUMN sess_timestart";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	$query = "ALTER TABLE $session DROP COLUMN sess_timemillis";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	$query = "ALTER TABLE $session ADD INDEX sess_timestamp ( `sess_timestamp` ) ";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	
	return '';
}
?>