<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Are you serial');
require_once('html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/are_you_serial/index.php');
}
$chall->showHeader();

# --- 8< --- 8< --- 8< --- 8< --- #

require_once 'insecure.inc.php'; # Include all the frameworks! \0=
require_once 'but.not.too.insecure.php'; # And fix all the frameworks! \0=

$form = new SERIAL_LoginForm(); # Use all the forms! =0/
$form_logout = new SERIAL_LogoutForm(); # \0=

# Login all the users
if (isset($_POST['login']))
{
	$form->execute(Common::getPostString('username'));
}
# Logout all the users
elseif (isset($_POST['logout']))
{
	$form_logout->execute();
}


# Logged in user
if (false !== ($user = unserialize(Common::getCookie('serial_user'))))
{
	# Red Herring
	if ($user->getUserlevel() >= 100)
	{
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
	
	# Show welcome screen
	echo GWF_HTML::message('Serial Challenger', $chall->lang('msg_wb', array(htmlspecialchars($user->getUsername()), $user->getPassword(), $user->getUserlevel())));
	
	# Show logout form
	echo $form_logout->serial_formz()->templateY($chall->lang('ft_logout'));
}

# Guest
else
{
	# Show login form
	echo $form->serial_formz()->templateY($chall->lang('ft_login'));
}

# --- 8< --- 8< --- 8< --- 8< --- #

echo $chall->copyrightFooter();
require_once 'html_foot.php';
?>