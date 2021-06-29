<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'The Mime Files');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/TheMimeFiles/index.php', false);
}
$chall->showHeader();

$href = 'http://themimefiles.warchall.net';
$href3 = 'https://github.com/gizmore/gwf3/tree/master/www/challenge/TheMimeFiles/www';
echo GWF_Box::box($chall->lang('info', [$href, $href3]), $chall->lang('title'));

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
