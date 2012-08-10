<?php
if (isset($_GET['show']))
{
	header('Content-Type: text/plain');
	die(file_get_contents('who.php'));
}
chdir('../../../');
define('GWF_PAGE_TITLE', 'What is your Name?');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 5, 'challenge/Mawekl/what_is_your_name/index.php', false);
}
$chall->showHeader();

require_once 'challenge/Mawekl/what_is_your_name/solution.php';
what_is_your_name_check_solution($chall);

$url1 = 'who.php';
$url2 = 'index.php?show=source';
$url3 = 'index.php?highlight=christmas';
$url4 = WC_Site::getByClassName('ST')->getURL();
$url4 = sprintf('<a href="%s" style="color: #eee;">Security Traps</a>', $url4);
if (false === ($mawekl = GWF_User::getByName('Mawekl')))
{
	$mawekl = 'Mawekl';
}
else
{
	$mawekl = sprintf('<a href="%s">Mawekl</a>', $mawekl->getProfileHREF()); 
}
$text = $chall->lang('info', array($mawekl, $url1, $url2, $url3, $url4));

htmlTitleBox($chall->lang('title'), $text);

if (Common::getGetString('highlight') === 'christmas')
{
	echo GWF_Message::display('[php title=who.php]'.file_get_contents('challenge/Mawekl/what_is_your_name/who.php').'[/php]');
}

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
