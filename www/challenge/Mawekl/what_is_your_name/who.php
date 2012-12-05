<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'What is your Name?');
define('NO_HEADER_PLEASE', '1');
require_once('challenge/html_head.php');
$SOLUTION_FLAG = require_once 'challenge/Mawekl/what_is_your_name/solution.php';
GWF_Debug::disableErrorHandler();
error_reporting(E_ERROR);
#########################
# Challenge starts here #
#########################
function honeypot($buff)
{
	return str_replace('mawekl', 'Mawekl', $buff);
}
ob_start('honeypot',4096);
session_start();
?>
<html><head><title>What is your name?</title><meta name="description" content="What is your name challenge from Mawekl on WeChall. It requires knowledge of PHP, Programming and Exploitation." /><meta name="keywords" content="Hackit,Challenge,PHP,Exploit" /><meta name="author" content="Mawekl" /><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><body><p>
<?php
if(isset($_SESSION['whoami']))
{
	if($_SESSION['whoami'] === 'Mawekl')
		echo 'Welcome Mawekl! Password is '.$SOLUTION_FLAG;
	else
		echo 'STRANGER! GO AWAY!';
	unset($_SESSION['whoami']);
}
elseif(isset($_GET['who']))
{
	$honeypot = ($_GET['honeypot'] * 1337) + 1.7;
	if(!preg_match('/[^0-9.E+]/',(string)$honeypot) && is_float((int)round($honeypot) - 33))
	{
		$_SESSION['whoami'] = 'Mawekl';
	}
	$who = (string)$_GET['who'];
	if($who == 'Mawekl')
	{
		echo 'You are not Mawekl! :[';
		$_SESSION['whoami'] = 'STRANGER';
	}
	else
	{
		echo htmlspecialchars('Welcome '.$who.'! ');
		$_SESSION['whoami'] = $who;
	}
}
else
{
	echo 'Who are you?!';
}
?>
</p></body></html>
