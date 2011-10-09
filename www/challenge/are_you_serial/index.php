<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Are you serial');
require_once('html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/are_you_serial/index.php');
}
$chall->showHeader();
# -------------------------- #
$files = array(
	'code.php',
	'insecure.inc.php',
	'SERIAL_LoginForm.php',
	'SERIAL_LogoutForm.php',
	'SERIAL_Solution.php',
	'SERIAL_User.php',
);
$a1 = codeanchor($files[0]);
$a2 = codeanchor($files[1]);
$a3 = codeanchor($files[2]);
$a4 = codeanchor($files[3]);
$a5 = codeanchor($files[4]);
$a6 = codeanchor($files[5]);
echo GWF_Box::box($chall->lang('info', array($a1, $a2, $a3, $a4, $a5, $a6, 'code.php')), $chall->lang('title'));
# -------------------------- #
$file = Common::getGetString('ShowSource', '');
if (in_array($file, $files, true))
{
	$path = 'challenge/are_you_serial/'.$file;
	$message = sprintf('[PHP title=%s]%s[/PHP]', $file, file_get_contents($path));
	echo GWF_Message::display($message);
}

# -------------------------- #
echo $chall->copyrightFooter();
require_once 'html_foot.php';

function codeanchor($file)
{
	$url = sprintf('index.php?ShowSource=%s', $file);
	return GWF_HTML::anchor($url, $file);
}
?>