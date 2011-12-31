<?php
# Change dir to web root
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: MySQL II');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/training/mysql/auth_bypass2/index.php', false);
}
$chall->showHeader();

echo GWF_Box::box($chall->lang('info', array('index.php?show=source', 'index.php?highlight=christmas', GWF_WEB_ROOT.'challenge/training/mysql/auth_bypass1/index.php')), $chall->lang('title'));


$filename = 'challenge/training/mysql/auth_bypass2/login.php';
if (Common::getGetString('show') === 'source') {
	echo GWF_Box::box('<pre>'.htmlspecialchars(file_get_contents($filename)).'</pre>');
}
elseif (Common::getGetString('highlight') === 'christmas') {
	$message = '[PHP]'.file_get_contents($filename).'[/PHP]';
	echo GWF_Message::display($message);
}


define('WCC_AUTH_BYPASS2_DB', 'gizmore_auth2');
define('WCC_AUTH_BYPASS2_USER', 'gizmore_auth2');
define('WCC_AUTH_BYPASS2_PASS', 'AuthIsBypassTwo');
include 'login.php';

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>