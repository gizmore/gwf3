<?php
/*
 * This is an example how your index.php could look like
 */
# Load config
require_once 'protected/config.php'; # <-- You might need to adjust this path.

# Init GDO and GWF core
require_once '%%GWFPATH%%gwf3.class.php';

# Init GWF
$gwf = new GWF3(getcwd(), array(
# Default values
//	'init' => true,
// 	'bootstrap' => false,
// 	'website_init' => true,
// 	'security_init' => true,
// 	'autoload_modules' => true,
// 	'load_module' => true,
// 	'load_config' => false,
// 	'start_debug' => true,
// 	'get_user' => true,
// 	'do_logging' => true,
// 	'log_request' => true,
// 	'blocking' => true,
// 	'no_session' => false,
// 	'store_last_url' => true,
// 	'ignore_user_abort' => true,
));
# Display page
echo $gwf->onDisplayPage();
?>
