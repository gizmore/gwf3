<?php
require 'config.php';
dldc_session_start();
require 'header.php';
?>
<?php
if (isset($_GET['logout']))
{
	dldc_logout();
	dldc_message("You are now logged out and all your traces have been wiped from your session.");
}
if (isset($_GET['login']))
{
	$username = trim(Common::getGetString('username'));
	if (!strcasecmp($username, 'administrator'))
	{
		# Prevent bruteforcing here, password has to be entered in challenge index.php
		dldc_error("The administrator account got disabled for security reasons.");
	}
	elseif (dldc_login($username, Common::getGetString('password')))
	{
		dldc_message("Welcome back {$username}, you are now authenticated with the service.");
	}
	else
	{
		dldc_error("Wrong username or password.");
	}
}
?>
<?php if (dldc_is_logged_in()) { ?>
<h1>Hello <?= dldc_username() ?>!</h1>
<p>You edit your profile here: <a class="button" href="profile.php">edit profile</a></p>
<p>You can use this button to logout: <a class="button" href="login.php?logout=now">logout</a></p>
<?php } else { ?>
<h1>Nice to meet you!</h1>
<div>
<form>
<table>
<tr><td>Username</td><td><input type="text" name="username" /></td></tr>
<tr><td>Password</td><td><input type="password" name="password" /></td></tr>
<tr><td colspan="2"><input type="submit" name="login" value="login" /></td></tr>
</table>
</form>
</div>
<?php }
require 'footer.php';
