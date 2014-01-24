<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Choose your Path');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/warchall/choose_your_path/index.php', false);
}
$chall->showHeader();
$chall->onCheckSolution();

$filename = 'challenge/warchall/choose_your_path/charp.c';
$home = '<i>/home/level/10/</i>';
$war_url = GWF_WEB_ROOT.'challenge/warchall/begins/index.php';
echo GWF_Box::box($chall->lang('info', array($home, $war_url, 'index.php?highlight=christmas')), $chall->lang('title'));

if (Common::getGetString('highlight') === 'christmas') {
	$message = '[code lang=C title=choose_your_path.c]'.file_get_contents($filename).'[/code]';
	echo GWF_Message::display($message);
}

formSolutionbox($chall, 14);
echo $chall->copyrightFooter();
require 'challenge/warchall/ads.php';
require_once('challenge/html_foot.php');
