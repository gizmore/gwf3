#!/usr/bin/php
<?php
if (PHP_SAPI !== 'cli')
{
	die('CLI Please');
}

# GWF_PATH
chdir('../../../www');

require_once '../core/inc/GDO/GDO.php';

define('GWF_CORE_PATH', '../core/');
define('GWF_USER_STACKTRACE', true);
define('GWF_DB_TYPE', 'mysqli');

$oldfix = 'hes2013_';
$newfix = 'wc4_';

$db = gdo_db_instance('localhost', 'nsc2013', 'nsc2013', 'nsc2013');
GDO::setCurrentDB($db);

if (false === ($result = $db->queryRead("SHOW TABLES")))
{
	die('ERROR 1');
}

while (false !== ($row = $db->fetchRow($result)))
{
	$tablename = $row[0];
	$new_tablename = preg_replace("/^$oldfix/", $newfix, $tablename);
	echo "$tablename => $new_tablename\n";
	$db->renameTable($tablename, $new_tablename);
}
