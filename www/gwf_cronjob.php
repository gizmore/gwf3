<?php
# May not call by browser
if (isset($_SERVER['REMOTE_ADDR']))
{
	die('Error 0915: Cronjob is called by www. Check GWF SERVER PATH.');
}

# Include Kernel
require_once 'protected/config.php';
require_once '../gwf3.class.php';

# Init
$gwf = new GWF3(dirname(__FILE__), array(
	'website_init' => true,
	'autoload_modules' => true,
	'load_module' => false,
	'load_config' => false,
	'start_debug' => true,
	'get_user' => false,
	'do_logging' => true,
	'blocking' => false,
	'no_session' => true,
	'store_last_url' => false,
	'ignore_user_abort' => false,
	'disallow_php_uploads' => false,
)); // WTF? may only load config?

# Call Cronjobs
//GWF_Log::logCron(GWF_ModuleLoader::cronjobs());
echo GWF_ModuleLoader::cronjobs();
?>
