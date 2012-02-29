<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Inka');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/inka/index.php', false);
}
$chall->showHeader();
$href = 'inka.php';
$href2 = 'inka.php?answer=1234';
$rage = 'http://www.youtube.com/watch?v=GSNeonapnT8#t=0m23';
$easteregg = sprintf('<a style="color: #fee;" href="%s">Eastereggs For The Winner!</a>', $rage);
echo GWF_Box::box($chall->lang('info', array($href, $href2, $easteregg)), $chall->lang('title'));
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
