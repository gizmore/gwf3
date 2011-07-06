<?php
/**
 * Define default values for the really needed config vars, so we can safely start without even a config.php.
 */
ini_set('display_errors', 1);
error_reporting(0xffffffff);
$domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '127.0.0.1';
$server_root = Common::substrUntil(__FILE__, DIRECTORY_SEPARATOR.'protected');
if (!defined('GWF_WEB_ROOT_NO_LANG')) { define('GWF_WEB_ROOT_NO_LANG', Common::substrUntil(__FILE__, 'protected/')); }
if (!defined('GWF_USER_STACKTRACE')) { define('GWF_USER_STACKTRACE', true); }
if (!defined('GWF_SITENAME')) { define('GWF_SITENAME', 'GWF3'); }
####//if (!defined('GWF_SERVER_PATH')) { define('GWF_SERVER_PATH', Common::substrUntil($_SERVER['SCRIPT_FILENAME'], '/protected/')); }
if (!defined('GWF_SMARTY_PATH')) { define('GWF_SMARTY_PATH', $server_root.'/core/inc3p/smarty/Smarty.class.php'); }

if (!defined('GWF_DEFAULT_LANG')) { define('GWF_DEFAULT_LANG', 'en'); }
if (!defined('GWF_DEFAULT_DESIGN')) { define('GWF_DEFAULT_DESIGN', 'default'); }
//if (!defined('GWF_SESS_LIFETIME')) { define('GWF_SESS_LIFETIME', 240); }
if (!defined('GWF_DB_DATABASE')) { define('GWF_DB_DATABASE', ''); }
if (!defined('GWF_DB_USER')) { define('GWF_DB_USER', ''); }
if (!defined('GWF_DB_PASSWORD')) { define('GWF_DB_PASSWORD', ''); }
if (!defined('GWF_DB_HOST')) { define('GWF_DB_HOST', 'localhost'); }
if (!defined('GWF_DB_TYPE')) { define('GWF_DB_TYPE', 'mysql'); }
if (!defined('GWF_DEBUG_EMAIL')) { define('GWF_DEBUG_EMAIL', 15); }
if (!defined('GWF_BOT_EMAIL')) { define('GWF_BOT_EMAIL', 'robot@'.$domain); }
if (!defined('GWF_CHMOD')) { define('GWF_CHMOD', 0777); }
?>