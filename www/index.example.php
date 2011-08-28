<?php

/**
 * This is an example how your index.php could look like
 */
require_once 'gwf3.class.php';

# Instance also loads config!
$gwf = new GWF3(__DIR__	, array(
## DEFAULT VALUES!
//	'website_init' => true,
//	'autoload_modules' => true,
//	'load_module' => true,
//	'get_user' => true,
//	'config_path' => GWF_PATH.'protected/config.php',
//	'logging_path' => GWF_PATH.'protected/logs',
//	'do_logging' => true,
//	'blocking' => true,
//	'no_session' => false,
//	'store_last_url' => true,
//	'ignore_user_abort' => true,
));

# Display Page
echo $gwf->onDisplayPage();

?>
