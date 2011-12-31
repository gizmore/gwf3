<?php
if (isset($_GET['show']) && $_GET['show'] === 'source') {
	header('Content-Type: text/plain');
	die(file_get_contents('globals.php'));
}

chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: Register Globals');
require_once('challenge/html_head.php');

if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/training/php/globals/index.php');
}
$chall->showHeader();

echo GWF_Box::box($chall->lang('info', array('index.php?show=source', 'index.php?highlight=christmas', 'globals.php')), $chall->lang('title'));

if (Common::getGetString('highlight') === 'christmas') {
	$code = ' [PHP title=globals.php]'.file_get_contents('challenge/training/php/globals/globals.php').'[/code]';
	echo GWF_Box::box(GWF_Message::display($code, true, false, false, array()));
}

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
