<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Shadowlamb - Chapter I');
require_once('html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/lamb/shadowlamb1/index.php');
}
$chall->showHeader();
echo GWF_Box::box(base64_encode($chall->lang('client_info')), $chall->lang('client_it'));
echo $chall->copyrightFooter();
require_once('html_foot.php');
?>
