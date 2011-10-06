<?php
chdir("../");
require_once 'protected/config.php';
require_once '../gwf3.class.php';
$gwf = new GWF3(dirname(__FILE__)	, array(
	'website_init' => true,
	'autoload_modules' => false,
	'load_module' => false,
	'get_user' => true,
//	'config_path' => 'protected/config.php',
//	'logging_path' => 'protected/logs',
	'do_logging' => false,
	'blocking' => false,
	'no_session' => false,
	'store_last_url' => false,
	'ignore_user_abort' => false,
));
//GWF_Session::start(false);
GWF_HTTP::noCache();
require(GWF_CORE_PATH.'inc/3p/Class_Captcha.php');
$aFonts = array(GWF_PATH.'extra/font/teen.ttf');
$rgbcolor = GWF_CAPTCHA_COLOR_BG;
$oVisualCaptcha = new PhpCaptcha($aFonts, 210, 42, $rgbcolor);
$oVisualCaptcha->Create('', Common::getGet('chars', true));
//GWF_Session::commit(false);
?>
