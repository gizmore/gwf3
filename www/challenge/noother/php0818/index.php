<?php
if (isset($_GET['show']) && is_string($_GET['show']))
{
	header('Content-Type: text/plain; charset=UTF-8;');
	die(file_get_contents('php0818.php'));
}
chdir('../../../');
define('GWF_PAGE_TITLE', 'PHP 0818');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/noother/php0818/index.php', false);
}
$chall->showHeader();
# -------------------------- #
$href1 = 'index.php?show=source';
$href2 = 'index.php?highlight=christmas';
echo GWF_Box::box($chall->lang('info', array($href1, $href2, 'php0818.php')), $chall->lang('title'));
# -------------------------- #
if (isset($_GET['highlight']))
{
	$message = '[PHP title=PHP0818]'.file_get_contents('challenge/noother/php0818/php0818.php').'[/PHP]';
	echo GWF_Box::box(GWF_Message::display($message));
}
# -------------------------- #
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>

