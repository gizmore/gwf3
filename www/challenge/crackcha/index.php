<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Crackcha');
require_once 'challenge/crackcha/crackcha.php';
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 8, 'challenge/crackcha/index.php', false);
}
$chall->showHeader();

echo GWF_Box::box($chall->lang('info', array('reset.php', 'problem.php', 'answer.php', 'highscore.php', GWF_Time::humanDuration(WCC_CRACKCHA_TIME), WCC_CRACKCHA_NEED)), $chall->lang('title'));

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>