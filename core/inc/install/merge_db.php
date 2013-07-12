#!/usr/bin/php
<?php
if (PHP_SAPI !== 'cli')
{
	die('CLI Please');
}

# GWF_PATH
chdir('../../../www');
require_once 'protected/config.php';
require_once '../gwf3.class.php';

$gwf = new GWF3(getcwd(), array(
'init' => true,
'bootstrap' => false,
'website_init' => true,
'autoload_modules' => false,
'load_module' => false,
'start_debug' => true,
'get_user' => false,
'do_logging' => false,
'buffered_log' => false,
'log_request' => false,
'blocking' => false,
'no_session' => true,
'store_last_url' => false,
'ignore_user_abort' => false,
'kick_banned_ip' => false,
));

require_once 'merge/mergefuncs.php';

GWF_Log::init(false, 0x7fffffff, 'protected/logs/merge');

if ($argc !== 6)
{
	merge_usage();
}

GWF_Log::logCron('======================');
GWF_Log::logCron('=== STARTING MERGE ===');
GWF_Log::logCron('======================');

if (false === ($db_from = merge_db($argv)))
{
	GWF_Log::logCritical('Connection to the import db failed!');
}

$db_to = gdo_db();

// Store some offsets, like highest user(sic) => 1234
$db_offsets = array();
$prefix = $argv[4];
$prevar = $argv[5];

$modules = GWF_ModuleLoader::loadModulesFS();
$modules = GWF_ModuleLoader::sortModules($modules, 'module_priority', 'ASC');

GWF_Log::logCron('=== LOADED MODULES ===');
GWF_Log::logCron('======================');

merge_core($db_from, $db_to, $db_offsets, $prefix, $prevar);

foreach ($modules as $module)
{
	$module instanceof GWF_Module;
	GWF_Cronjob::notice(sprintf('MERGE MODULE %s', $module->getName()));
	GWF_ModuleLoader::includeAll($module);
	$module->onMerge($db_from, $db_to, $db_offsets, $prefix, $prevar);
}
