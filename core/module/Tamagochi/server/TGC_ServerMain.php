<?php
/*
 * This is an example how your index.php could look like
*/
# Security headers

require_once '../vendor/autoload.php';

# Load config
require_once 'protected/config.php'; # <-- You might need to adjust this path.

# Init GDO and GWF core
require_once '../gwf3.class.php';

# Websockets

GWF_HTML::init();
GWF_Debug::setDieOnError(false);
GWF_Debug::setMailOnError(false);
$_GET['ajax'] = 1;

# Init GWF
$gwf = new GWF3(getcwd(), array(
# Default values
	'init' => true,
	'bootstrap' => true,
	'website_init' => false,
	'autoload_modules' => true,
	'load_module' => false,
	'load_config' => false,
	'start_debug' => true,
	'get_user' => false,
	'do_logging' => true,
	'log_request' => false,
	'blocking' => true,
	'no_session' => true,
	'store_last_url' => true,
	'ignore_user_abort' => false,
));


# Load TGC
if (false === ($tgc = GWF_Module::loadModuleDB("Tamagochi", true, true, true))) {
	die('Module not found.');
}

require_once 'TGC_Global.php';
require_once 'TGC_ServerUtil.php';
require_once 'TGC_Commands.php';

require_once '../core/module/Tamagochi/server/TGC_Server.php';

$server = new TGC_Server();
$server->initTamagochiServer();
$server->mainloop();
