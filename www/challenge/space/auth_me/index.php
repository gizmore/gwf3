<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'AUTH me');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/space/auth_me/index.php', false);
}
$chall->showHeader();

$href_conf = 'find_me/apache.conf';
$href_httpd = 'https://authme.wechall.net/challenge/space/auth_me/www/index.php';
echo GWF_Box::box($chall->lang('info', array($href_conf, $href_httpd)), $chall->lang('title'));

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
