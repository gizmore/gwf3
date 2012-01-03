<?php
require_once 'protected/config.php';
require_once '../gwf3.class.php';
$gwf = new GWF3(dirname(dirname(__FILE__).'../'), array(
		'init' => true, # Init?
		'bootstrap' => false, # Init GWF_Bootstrap?
		'website_init' => true, # Init GWF_Website?
		'autoload_modules' => true, # Load modules with autoload flag?
		'load_module' => false, # Load the requested module?
		'load_config' => false, # Load the config file? (DEPRECATED) # TODO: REMOVE
		'start_debug' => true, # Init GWF_Debug?
		'get_user' => true, # Put user into smarty templates?
		'do_logging' => true, # Init the logger?
		'log_request' => true, # Log the request?
		'blocking' => !defined('GWF_SESSION_NOT_BLOCKING'),
		'no_session' => false, # Suppress session creation?
		'store_last_url' => true, # Save the current URL into session?
		'ignore_user_abort' => true, # Ignore abort and continue the script on browser kill?
));
// $gwf->init();
?>