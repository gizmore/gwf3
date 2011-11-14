<?php
chdir("../");

# You may need to change your config path.
require_once 'protected/config.php';

# You may need to change your gwf path.
require_once '../gwf3.class.php';

# Init GWFv3
$gwf = new GWF3(dirname(__FILE__)	, array(
	'website_init' => true,
	'autoload_modules' => false,
	'load_module' => false,
	'load_config' => false,
	'start_debug' => true,
	'get_user' => false,
	'do_logging' => true,
	'blocking' => false,
	'no_session' => false,
	'store_last_url' => false,
	'ignore_user_abort' => true,
	'disallow_php_uploads' => true,
));

# Output the captcha
GWF_HTTP::noCache();
require(GWF_CORE_PATH.'inc/3p/Class_Captcha.php');
$aFonts = array(GWF_PATH.'extra/font/teen.ttf');
$rgbcolor = GWF_CAPTCHA_COLOR_BG;
$oVisualCaptcha = new PhpCaptcha($aFonts, 210, 42, $rgbcolor);
$oVisualCaptcha->Create('', Common::getGetString('chars', true));
?>
