<?php
$solution = require 'pytong_solution.php';
chdir('../../../');
define('GWF_PAGE_TITLE', 'Py-Tong');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/space/pytong/index.php', $solution);
}
$chall->showHeader();
$chall->onCheckSolution();

echo GWF_Box::box($chall->lang('info', array('index.php?show=source', 'index.php?highlight=christmas')), $chall->lang('title'));

$filename = 'challenge/space/pytong/pytong.py';
if (Common::getGetString('show') === 'source') {
	echo GWF_Box::box('<pre>'.htmlspecialchars(file_get_contents($filename)).'</pre>');
}
elseif (Common::getGetString('highlight') === 'christmas') {
	$message = '[PHP]'.file_get_contents($filename).'[/PHP]';
	echo GWF_Message::display($message);
}

formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');

