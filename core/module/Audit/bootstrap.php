<?php
require_once 'ruth/config.php';
$_GET['ajax'] = 1;
require_once '/opt/php/gwf3/gwf3.class.php';
if (false === ($db = gdo_db_instance('localhost', 'warchall', 'ThreeLittlePonies', 'warchall')))
{
	die('EEK DB GONE!');
}
$db->lock('CRON');
?>