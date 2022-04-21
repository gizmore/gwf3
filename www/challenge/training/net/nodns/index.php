<?php
$domain = require 'domain.php';
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: No DNS');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/net/nodns/index.php', false);
}
$chall->showHeader();

$href = 'https://'.$domain.'/challenge/training/nodns/etc/hosts.php';
echo GWF_Box::box($chall->lang('info', [$href]), $chall->lang('title'));

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
