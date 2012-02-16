<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Are you serial');
require_once('challenge/gwf_include.php');
GWF_Module::loadModuleDB('WeChall', true, true);
GWF_Module::loadModuleDB('Forum', true, true);
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/are_you_serial/index.php');
}

# --- 8< --- 8< --- SNIP --- 8< --- 8< --- #
# The new fast code!

require_once 'insecure.inc.php';
$form = new SERIAL_LoginForm();
$form_logout = new SERIAL_LogoutForm();

### Action
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

### Display
echo $gwf->onDisplayHead();
$chall->showHeader();

# Logged in user
if (false !== ($user = unserialize(Common::getCookie('serial_user', ''))))
{
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

# --- 8< --- 8< --- SNIP --- 8< --- 8< --- #

echo $chall->copyrightFooter();
require_once 'challenge/html_foot.php';
?>
