<?php
chdir("../");
require_once '../gwf3.class.php';
$gwf = new GWF3(__DIR__	, array(
	'website_init' => false,
	'autoload_modules' => false,
	'load_module' => false,
	'get_user' => false,
//	'config_path' => GWF_PATH.'protected/config.php',
//	'logging_path' => GWF_PATH.'protected/logs',
	'do_logging' => false,
	'blocking' => false,
	'no_session' => false,
	'store_last_url' => false,
));
//GWF_Session::start(false);
GWF_HTTP::noCache();
require(GWF_CORE_PATH.'inc/3p/Class_Captcha.php');
$aFonts = array(GWF_PATH.'font/teen.ttf');
$rgbcolor = GWF_CAPTCHA_COLOR_BG;
$oVisualCaptcha = new PhpCaptcha($aFonts, 210, 42, $rgbcolor);
$oVisualCaptcha->Create('', Common::getGet('chars', true));
//GWF_Session::commit(false);
?>
