<?php
chdir('../../../../');
define('GWF_PAGE_TITLE', 'The Travelling Customer');
require_once 'challenge/html_head.php';
require_once 'challenge/training/programming/knapsaak/salesman.php';

if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/training/programming/knapsaak/index.php');
}
$chall->showHeader();

echo GWF_Box::box($chall->lang('info', array('problem.php', 'answer.php', WCC_TR_CU_COUNT, WCC_TR_CU_TIMEOUT)), $chall->lang('title'));

$url1 = 'http://xkcd.com/287/';
$url1 = GWF_HTML::anchor($url1, $url1);
$url2 = 'http://xkcd.com/399/';
$url2 = GWF_HTML::anchor($url2, $url2);
echo GWF_Box::box($chall->lang('credits_body', array($url1, $url2)), $chall->lang('credits_title'));

echo $chall->copyrightFooter();
require_once 'challenge/html_foot.php';
?>