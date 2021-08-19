<?php
chdir('../../../');
define('GWF_PAGE_TITLE', '2020 Christmas Special');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH . 'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 5, 'challenge/quangntenemy/2020_Christmas_Special/index.php', false);
}
$chall->showHeader();

$chall->onCheckSolution();

echo "<!-- BEGIN OF CHALLENGE -->\n";
$image = sprintf('<img src="wechall-newyear.png" title="wechall-newyear.png" alt="wechall-newyear.png" />');
echo GWF_Box::box($chall->lang('info', [$image]), $chall->lang('title'));
echo "<!-- END OF CHALLENGE -->\n";

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
