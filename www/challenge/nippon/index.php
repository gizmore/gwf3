<?php
$signs = require('signs.php');
$solution = require 'solution.php';
chdir('../../');
define('GWF_PAGE_TITLE', 'Nippon');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/nippon/index.php', $solution);
}
$chall->showHeader();

if (isset($_POST['answer']))
{
	$answ = $_POST['answer'];
	for ($i = 0; $i < 3; $i++)
	{
		$answ = sha1($answ);
	}
	$_POST['answer'] = $answ;
	$chall->onCheckSolution();
	$_POST['answer'] = '';
}


echo GWF_Box::box($chall->lang('info', $signs), $chall->lang('title'));

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
