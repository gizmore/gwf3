<?php
# Change dir to web root
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: MySQL I');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/training/mysql/auth_bypass1/index.php', false);
}
$chall->showHeader();

echo GWF_Box::box($chall->lang('info', array('index.php?show=source', 'index.php?highlight=christmas')), $chall->lang('title'));


$filename = 'challenge/training/mysql/auth_bypass1/login.php';
if (Common::getGetString('show') === 'source') {
	echo GWF_Box::box('<pre>'.htmlspecialchars(file_get_contents($filename)).'</pre>');
}
elseif (Common::getGetString('highlight') === 'christmas') {
	$message = '[PHP]'.file_get_contents($filename).'[/PHP]';
	echo GWF_Message::display($message);
}


define('WCC_AUTH_BYPASS1_DB', 'gizmore_auth1');
define('WCC_AUTH_BYPASS1_USER', 'gizmore_auth1');
define('WCC_AUTH_BYPASS1_PASS', 'AuthIsBypass');
include 'login.php';

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');

?>