<?php

/**
 * This is an example how your index.php could look like
 */
require_once 'protected/config.php';
require_once 'gwf3.class.php';

# Instance also loads config!
$gwf = new GWF3(__DIR__	, array(
## DEFAULT VALUES!
//      'website_init' => true,
//      'autoload_modules' => true,
//      'load_module' => true,
//      'load_config' => false,
//      'start_debug' => true,
//      'get_user' => true,
//      'do_logging' => true,
//      'blocking' => true,
//      'no_session' => false,
//      'store_last_url' => true,
//      'ignore_user_abort' => true,
//      'disallow_php_uploads' => true,
));

# Display Page
echo $gwf->onDisplayPage();

?>
