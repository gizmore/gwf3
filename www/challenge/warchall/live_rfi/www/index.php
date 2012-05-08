<?php
require_once 'live_rfi.config.php';

require_once '/opt/php/gwf3/GWF3.php';

$gwf = new GWF3(getcwd());

// require_once '../../../../../gwf3.class.php';
// $gwf = new GWF3(getcwd(), array(
// 'init' => false,
// 'bootstrap' => false,
// 'website_init' => false,
// 'autoload_modules' => false,
// 'load_module' => false,
// 'load_config' => false,
// 'start_debug' => true,
// 'get_user' => false,
// 'do_logging' => true,
// 'log_request' => true,
// 'blocking' => false,
// 'no_session' => true,
// 'store_last_url' => false,
// 'ignore_user_abort' => true,
// 'kick_banned_ip' => false,
// ));

# include
GWF_Website::displayPage('aaa');

$iso = Common::getGetString('lang', 'en');

ini_set('open_basedir', getcwd());
$lang = require $iso;
ini_set('open_basedir', '/');

$page = sprintf('%s<br/>%s', $lang['welcome'], $lang['construction']);

echo GWF_Website::displayPage($page);
?>
