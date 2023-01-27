<?php
$sol = require 'solution2.php';
$solution = require 'solution.php';
chdir('../../../');
define('GWF_PAGE_TITLE', 'CAG: Base64');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/coding_ala_giz/02_20_base64/index.php', $sol);
}
$chall->showHeader();
$chall->onCheckSolution();
$url = 'https://en.wikipedia.org/wiki/Base64';
$problem = base64_encode($solution);
echo GWF_Box::box($chall->lang('info', [$url, $problem]), $chall->lang('title'));
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
