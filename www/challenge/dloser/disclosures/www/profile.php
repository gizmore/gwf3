<?php
require 'config.php';
dldc_session_start();
require 'header.php';

$user = dldc_user();
if (!$user)
{
	dldc_error('Login required!');
}
else
{
	if (isset($_POST['update']))
	{
		dldc_update_profile($user, Common::getPostString('password_new'));
	}
	require 'profile_form.php';
}
?>
<?php
function dldc_update_profile(DLDC_User $user, $password)
{
	$data = array(
		'email' => trim(Common::getPostString('email')),
		'firstname' => trim(Common::getPostString('firstname')),
		'lastname' => trim(Common::getPostString('lastname')),
	);
	if (!empty($password))
	{
		if (!DLDC_User::login(dldc_username(), Common::getPostString('password_old')))
		{
			return dldc_error('You have to supply your current password to change it.');
		}
		if ($password !== Common::getPostString('password_retype'))
		{
			return dldc_error('You have to retype your new password correctly.');
		}
		$data['password'] = DLDC_User::hashPassword($password);
		dldc_message('Your password has been changed!');
	}
	
	$user->saveVars($data);
	dldc_message('Information has been saved.');
}
?>
<?php
require 'footer.php';
