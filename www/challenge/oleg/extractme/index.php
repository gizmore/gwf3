<?php
$solution = require 'oleg_solution.php';
chdir('../../../');
define('GWF_PAGE_TITLE', 'eXtract Me');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/oleg/extractme/index.php', $solution);
}
$chall->showHeader();
$chall->onCheckSolution();
echo GWF_Box::box($chall->lang('info', array('r.zip')), $chall->lang('title'));
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
