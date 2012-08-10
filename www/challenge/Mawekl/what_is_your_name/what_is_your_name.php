<?php
ob_start();
chdir('../../../');
define('GWF_PAGE_TITLE', 'What is your Name?');
require_once('challenge/html_head.php');
#########################
# Challenge starts here #
#########################

session_start();
$password = 'challenge/Mawekl/what_is_your_name/solution.php';
if(isset($_SESSION['whoami']))
{
	if($_SESSION['whoami'] === 'Mawekl')
		echo 'Welcome Mawekl! Password is '.$password;
	else
		echo 'STRANGER! GO AWAY!';
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

########################
### End of challenge ###
########################
require_once('challenge/html_foot.php');
?>
