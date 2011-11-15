<?php
# May not call by browser. In theory this file is accessible in some setups.
if (isset($_SERVER['REMOTE_ADDR']))
{
	die('Error 0915: Cronjob is called by www.');
}
# Switch to non HTML output
$_GET['ajax'] = 1;

# Include config
require_once 'protected/config.php'; # You may need to change this path.

# Include core
require_once '../gwf3.class.php'; # You may need to change this path too.

# Init
$gwf = new GWF3(getcwd(), array(
	'bootstrap' => false,
	'website_init' => true,
	'autoload_modules' => false,
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
));

# Call cronjobs
GWF_ModuleLoader::cronjobs();
?>
