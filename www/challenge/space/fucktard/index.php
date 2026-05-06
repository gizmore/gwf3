<?php
$solution = require 'solution.php';
chdir('../../../');
define('GWF_PAGE_TITLE', 'Fu*ktard!');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';

if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/space/fucktard/index.php', $solution);
}

$chall->showHeader();
if (isset($_POST['answer']))
{
	$answ = strtolower($_POST['answer']);
	for ($i = 0; $i < 5; $i++)
	{
		$answ = hash('sha384', $answ);
	}
	$_POST['answer'] = $answ;
	$chall->onCheckSolution();
	$_POST['answer'] = '';
}

$text = file_get_contents('challenge/space/fucktard/utf8.fcked');
$text = '[code=brainfuck]' . $text . '[/code]';
echo GWF_Box::box($chall->lang('info') . GWF_Box::box(GWF_Message::display($text)), $chall->lang('title'));

formSolutionbox($chall);
echo '<!-- Not all alphabets are modern! -->';
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
