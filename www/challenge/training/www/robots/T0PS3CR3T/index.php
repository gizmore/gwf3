<?php
chdir('../../../../../');
define('GWF_PAGE_TITLE', 'Training: WWW-Robots');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/www/robots/index.php');
}
$chall->showHeader();
$chall->onChallengeSolved(GWF_Session::getUserID());
echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>