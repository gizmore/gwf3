<?php

function Upgrade_SF_1_03()
{
	$db = gdo_db();
	$sf = GWF_TABLE_PREFIX.'SF_Navigation';
	$query = "ALTER TABLE $sf ADD COLUMN options int(10) unsigned NOT NULL DEFAULT '1'";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}

	ini_set('memory_limit', '2048MB');
	ini_set('max_execution_time', '3600');
	
	$foo = GDO::table('SF_Navigation');
	$succ = true;
	
	$fo = array();
	$fo[] = array("side='left'", SF_Navigation::SIDE_LEFT);
	$fo[] = array("side='right'", SF_Navigation::SIDE_RIGHT);
	$fo[] = array("side='SEC'", SF_Navigation::SECLINK);
	$fo[] = array("side='CAT'", SF_Navigation::CATLINK);
	$fo[] = array("side='SUB'", SF_Navigation::SUBLINK);
	$fo[] = array("is_visible=1", SF_Navigation::VISIBLE);
	$fo[] = array("TID=1", SF_Navigation::SECTIONS);
	$fo[] = array("TID=2", SF_Navigation::CATEGORIES);
	$fo[] = array("TID=3", SF_Navigation::SUBCATS);
	$fo[] = array("TID=4", SF_Navigation::LINKS);
	foreach($fo as $arr)
		foreach($foo->selectAll('ID', $arr[0]) as $id)
		{
			if(false === $foo->getBy('ID', $id['ID'])->saveOption($arr[1]))
				$succ = false;
		}

	if($succ)
	{
		$query = "ALTER TABLE `$sf` DROP `TID`, DROP `side`, DROP `is_visible`, DROP `display_to`";
		if (false === $db->queryWrite($query)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
	}
	return $succ;
}