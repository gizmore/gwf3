<?php
chdir("../");
require_once 'inc/_gwf_include.php';
GWF_Session::start(false);
require('inc3p/Class_Captcha.php');
GWF_HTTP::noCache();
$aFonts = array('font/teen.ttf');
$rgbcolor = GWF_CAPTCHA_COLOR_BG;
$oVisualCaptcha = new PhpCaptcha($aFonts, 210, 42, $rgbcolor);
$oVisualCaptcha->Create('', Common::getGet('chars', true));
GWF_Session::commit(false);
?>
