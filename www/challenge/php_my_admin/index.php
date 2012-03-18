<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'PHP My Admin');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/php_my_admin/index.php', false);
}
$chall->showHeader();
echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
