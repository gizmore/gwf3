<?php
require 'config.php';
dldc_session_start();
require 'header.php';
?>
<?php
function dldc_reqister($username, $password, $email, $firstname, $lastname)
{
	if (!dldc_is_valid_username($username))
	{
		dldc_error('Invalid username. Start with a letter and then add 2-23 digits, letters or underscores.');
	}
	elseif (!dldc_is_valid_password($password))
	{
		dldc_error('Your password is not secure enough for this service.');
	}
	elseif ($password !== Common::getPostString('password_retype'))
	{
		dldc_error('You have to confirm your password by retyping it.');
	}
	elseif (empty($email))
	{
		dldc_error('Please fill in an email address.');
	}
	elseif (DLDC_User::existsUsername($username))
	{
		dldc_error('Username already registered.');
	}
	elseif (DLDC_User::existsEMail($email))
	{
		dldc_error('E-mail already used for another account.');
	}
	else
	{
		dldc_cleanup(); # DELETE YOUR OLD "PLAYER"!
		if (!DLDC_User::create($username, $password, $email, $firstname, $lastname))
		{
			dldc_error('An error occurred!');
		}
		else
		{
			dldc_message('You have been successfully registered!');
		}
	}
}
if (dldc_is_logged_in())
{
	dldc_error('You are already registered. Logout first!');
}
else
{
	if (isset($_POST['register']))
	{
		dldc_reqister(trim(Common::getPostString('username')),Common::getPostString('password'),
				trim(Common::getPostString('email')),
				trim(Common::getPostString('firstname')), trim(Common::getPostString('lastname')));
	}
	require 'register_form.php';
}
?>
<?php
require 'footer.php';
