<?php
$domain = require '../domain.php';

chdir('../../../../../');
define('GWF_PAGE_TITLE', 'Training: No DNS');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/net/nodns/index.php', false);
}
$chall->showHeader();

if ($_SERVER['HTTP_HOST'] === $domain)
{
	$chall->onChallengeSolved();
}
else
{
	echo GWF_HTML::error('No DNS',  $chall->lang('err_host', [$domain]));
}

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
