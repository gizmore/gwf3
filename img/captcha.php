<?php
chdir("../");
require_once 'gwf3.class.php';
GWF3::onLoadConfig(GWF_CONFIG_PATH);
GWF_Session::start(false);
require('core/inc3p/Class_Captcha.php');
GWF_HTTP::noCache();
$aFonts = array('font/teen.ttf');
$rgbcolor = GWF_CAPTCHA_COLOR_BG;
$oVisualCaptcha = new PhpCaptcha($aFonts, 210, 42, $rgbcolor);
$oVisualCaptcha->Create('', Common::getGet('chars', true));
GWF_Session::commit(false);
?>
