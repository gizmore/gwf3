<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

require_once __DIR__ . '/config.php';
//define('GWF_PATH', dirname(__DIR__).'/');
//$basepath = GWF_PATH . 'www';
//define('GWF_WWW_PATH', $basepath.'/');
//define('GWF_CORE_PATH', GWF_PATH.'core/');

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
    'env' => 'test',
));

