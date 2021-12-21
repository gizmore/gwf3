<?php
$solution = require 'solution.php';
chdir('../../../');
define('GWF_PAGE_TITLE', '2021 Christmas Grampa');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH . 'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/christmas2021/grampa/index.php', $solution);
}
$chall->showHeader();

$chall->onCheckSolution();

echo "<!-- BEGIN OF CHALLENGE -->\n";
$accepted = 'https://github.com/gizmore/gwf3/tree/master/www/challenge/christmas2021/grampa/';
echo GWF_Box::box($chall->lang('info', [$accepted]), $chall->lang('title'));
echo "<!-- END OF CHALLENGE -->\n";

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
