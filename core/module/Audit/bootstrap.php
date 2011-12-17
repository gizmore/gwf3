<?php
require_once 'ruth/config.php';
$_GET['ajax'] = 1;
require_once '/opt/php/gwf3/gwf3.class.php';
# Init
$gwf = new GWF3(getcwd(), array(
		'bootstrap' => false,
		'website_init' => false,
		'autoload_modules' => false,
		'load_module' => false,
		'load_config' => false,
		'start_debug' => true,
		'get_user' => false,
		'do_logging' => true,
		'log_request' => false,
		'blocking' => false,
		'no_session' => true,
		'store_last_url' => false,
		'ignore_user_abort' => false,
));

GWF_Language::initEnglish();
GWF_HTML::init();

$db = gdo_db();
// if (false === ($db = gdo_db_instance('localhost', 'warchall', 'ThreeLittlePonies', 'warchall')))
// {
// 	die('EEK DB GONE!');
// }
$db->lock('CRON');
?>