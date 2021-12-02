<?php
$solution = require 'solution.php';
chdir('../../../');
define('GWF_PAGE_TITLE', '2021 Christmas Tweet');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH . 'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/christmas2021/tweet/index.php', $solution);
}
$chall->showHeader();

$chall->onCheckSolution();

echo "<!-- BEGIN OF CHALLENGE -->\n";
$href = 'https://twitter.com/Gizmore/status/1466513376385843210';
echo GWF_Box::box($chall->lang('info', [$href]), $chall->lang('title'));
echo "<!-- END OF CHALLENGE -->\n";

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
