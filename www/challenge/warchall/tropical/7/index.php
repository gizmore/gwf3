<?php
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: Warchall - 7 Tropical Fruits');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 8, 'challenge/warchall/tropical/7/index.php');
}
$chall->showHeader();
$chall->onCheckSolution();

echo GWF_Box::box($chall->lang('info', array('/challenge/warchall/begins/index.php', 'index.php?highlight=christmas'), $chall->lang('title')));

$filename = 'challenge/warchall/tropical/7/level7.c';
if (Common::getGetString('highlight') === 'christmas') {
	$message = '[code lang=C title=tropic7.c]'.file_get_contents($filename).'[/code]';
	echo GWF_Message::display($message);
}

formSolutionbox($chall, 18);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
