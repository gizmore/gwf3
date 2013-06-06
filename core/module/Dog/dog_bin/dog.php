<?php
chdir(dirname(__FILE__));
chdir('../');

$config_file = $argv[1];

require_once '../../../www/protected/'.$config_file;
require_once '../../../gwf3.class.php';
$gwf = new GWF3(NULL, array(
'init' => true, # Init?
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
'kick_banned_ip' => false, # Kick banned IP adress by temp_ban file?
));
GWF_HTML::init();
GWF_Log::init(false, GWF_Log::_DEFAULT-GWF_Log::BUFFERED, GWF_PATH.'www/protected/logs/dog');
$_GET['ajax'] = 1;
GWF_Debug::setDieOnError(false);
gdo_db();
// GWF_Debug::disableErrorHandler();

require_once 'Dog.php';

// dog 
if (isset($argv[2]) && $argv[2] === 'install')
{
	require_once 'mini_install.php';
}

Dog_Init::init();

if ( (!defined('DOG_NO_LAUNCH')) && (Dog_Init::validate()) )
{
	Dog::mainloop();
}
?>
