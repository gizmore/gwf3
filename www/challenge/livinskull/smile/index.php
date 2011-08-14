<?php
if ( (isset($_GET['show'])) && (is_string($_GET['show'])) )
{
	if ($_GET['show'] === 'smile')
	{
		header('Content-Type: text/plain;');
		die(file_get_contents('smile.php'));
	}
	elseif ($_GET['show'] === 'livin_smile')
	{
		header('Content-Type: text/plain;');
		die(file_get_contents('LIVIN_Smile.php'));
	}
}
# -------------------------- #
chdir('../../../');
define('GWF_PAGE_TITLE', 'Smile');
require_once('html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/livinskull/smile/index.php', false);
}
$chall->showHeader();
# -------------------------- #
if (false !== ($answer = Common::getPostString('answer', false)))
{
	require_once 'challenge/livinskull/smile/LIVIN_Smile.php';
	$solution = LIVIN_Smile::getSolution();
	if ($answer === $solution)
	{
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
	else
	{
		echo WC_HTML::error('err_wrong');
	}
}
# -------------------------- #
$url1 = 'index.php?show=smile';
$url2 = 'index.php?highlight=smile';
$url3 = 'index.php?show=livin_smile';
$url4 = 'index.php?highlight=livin_smile';
$url5 = 'smile.php';
echo GWF_Box::box($chall->lang('info', array($url1, $url2, $url3, $url4, $url5)), $chall->lang('title'));
# -------------------------- #
if (false !== ($file = Common::getGetString('highlight', false)))
{
	$files = array('smile'=>'smile.php', 'livin_smile'=>'LIVIN_Smile.php');
	if (isset($files[$file]))
	{
		$content = file_get_contents("challenge/livinskull/smile/".$files[$file]);
		$message = '[PHP]'.$content.'[/PHP]';
		echo GWF_Box::box(GWF_Message::display($message), $files[$file]);
	}
}
# -------------------------- #
echo formSolutionbox($chall);
# -------------------------- #
echo $chall->copyrightFooter();
require_once 'html_foot.php';
?>