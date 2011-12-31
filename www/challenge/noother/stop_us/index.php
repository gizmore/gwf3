<?php
if (isset($_GET['show']) && is_string($_GET['show']))
{
	if ($_GET['show'] === 'source')
	{
		header('Content-Type: text/plain; charset=UTF-8;');
		die(file_get_contents('nootherdomain.php'));
	}
	elseif($_GET['show'] === 'noothtable')
	{
		header('Content-Type: text/plain; charset=UTF-8;');
		die(file_get_contents('noothtable.php'));
	}
}
chdir('../../../');
define('GWF_PAGE_TITLE', 'Stop us');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/noother/stop_us/index.php', false);
}
$chall->showHeader();
# -------------------------- #
$href1 = 'index.php?show=source';
$href2 = 'index.php?highlight=christmas';
$href3 = 'index.php?show=noothtable';
$href4 = 'index.php?highlight=noothtable';
$jjk = 'jjk';
$dloser = 'dloser';
echo GWF_Box::box($chall->lang('info', array('nootherdomain.php', $href1, $href2, $href3, $href4, $jjk, $dloser)), $chall->lang('title'));
# -------------------------- #
if (false !== ($file = Common::getGetString('highlight', false)))
{
	if ($file === 'noothtable')
	{
		$file = 'noothtable.php';
	}
	else 
	{
		$file = 'nootherdomain.php';
	}
	$message = '[PHP title='.$file.']'.file_get_contents('challenge/noother/stop_us/'.$file).'[/PHP]';
	echo GWF_Box::box(GWF_Message::display($message));
}
# -------------------------- #
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>

