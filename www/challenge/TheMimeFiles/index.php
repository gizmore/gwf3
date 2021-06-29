<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'The Mime Files');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/TheMimeFiles/index.php', false);
}
$chall->showHeader();

$href = 'themimefiles.warchall.net';
echo GWF_Box::box($chall->lang('info', [$href]), $chall->lang('title'));

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
