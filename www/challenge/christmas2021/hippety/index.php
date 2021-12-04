<?php
$solution = require 'solution.php';
chdir('../../../');
define('GWF_PAGE_TITLE', '2021 Christmas Hippety');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH . 'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/christmas2021/hippety/index.php', $solution);
}
$chall->showHeader();

$chall->onCheckSolution();

echo "<!-- BEGIN OF CHALLENGE -->\n";
echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));
echo "<!-- END OF CHALLENGE -->\n";

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
