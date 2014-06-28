<?php
$solution = require 'solution.php';
// $base = file_get_contents('base.php');
chdir('../../../');
define('GWF_PAGE_TITLE', 'The BrownOS');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 7, 'challenge/dloser/brownos/index.php', $solution);
}
$chall->showHeader();

if (isset($_POST['answer']))
{
	$answ = $_POST['answer'];
	for ($i = 0; $i < 56154; $i++)
	{
		$answ = sha1($answ);
	}
	$_POST['answer'] = $answ;
	$chall->onCheckSolution();
	$_POST['answer'] = '';
}

echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));

echo GWF_Box::box($chall->lang('cheatsheet'), $chall->lang('subtitle'));

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
