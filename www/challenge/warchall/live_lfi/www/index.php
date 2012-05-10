<?php
require_once 'live_lfi.config.php';

require_once '/opt/php/gwf3/GWF3.php';

$gwf = new GWF3(getcwd());

GWF_Debug::enableErrorHandler();

$iso = Common::getGetString('lang', 'en');
$lang = require_once $iso;
$page = sprintf('%s<br/>%s', $lang['welcome'], $lang['construction']);
echo GWF_Website::displayPage($page);
?>
