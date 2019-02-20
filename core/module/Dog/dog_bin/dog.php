<?php
chdir(dirname(__FILE__));
chdir('../');

define('DOG_WS_QUEUE', true);

# Require config
$config_file = $argv[1];
require_once '../../../www/protected/'.$config_file;

# and gwf
require_once '../../../gwf3.class.php';
$gwf = new GWF3(NULL, array(
	'init' => true, # Init?
	'security_init' => false, # not needed for cli.
	'bootstrap' => false, # Init GWF_Bootstrap?
	'website_init' => false, # Init GWF_Website?
	'autoload_modules' => false, # Load modules with autoload flag?
	'load_module' => false, # Load the requested module?
	'load_config' => false, # Load the config file? (DEPRECATED) # TODO: REMOVE
	'start_debug' => true, # Init GWF_Debug?
	'get_user' => false, # Put user into smarty templates?
	'do_logging' => false, # Init the logger?
	'log_request' => false, # Log the request?
	'blocking' => true, # Lock the database, so we can request only one page by one?
	'no_session' => true, # Suppress session creation?
	'store_last_url' => false, # Save the current URL into session?
	'ignore_user_abort' => false, # Ignore abort and continue the script on browser kill?
	'kick_banned_ip' => false, # Kick banned IP address by temp_ban file?
	'env' => isset($argv[5]) ? $argv[5] : 'prod',
	'unix_user' => isset($argv[6]) ? $argv[6] : 'root',
));

# That´s all of GWF3 we will share with the worker.
GWF_Debug::setDieOnError(false);
GWF_Debug::setMailOnError(false);
$_GET['ajax'] = 1;

# And this is the worker process
require 'dog_include/Dog_WorkerThread.php';
$worker = new Dog_WorkerThread();
$worker->start();

# Parent resources
GWF_Log::init(false, GWF_Log::_DEFAULT-GWF_Log::BUFFERED, GWF_PATH.'www/protected/logs/dog');
gdo_db();

# Dog please
require_once 'Dog.php';
Dog::setUnixUsername(GWF3::getConfig('unix_user'));

# Dog installer 
if (isset($argv[2]) && $argv[2] === 'install')
{
	require_once 'mini_install.php';
}

# Dog init
Dog_Init::init($worker);

# Dog l(a)unch
if ( (!defined('DOG_NO_LAUNCH')) && (Dog_Init::validate()) )
{
	Dog::mainloop();
}
