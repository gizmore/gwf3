<?php
function dldc_session_start()
{
	session_start();
}

function dldc_die($message=0)
{
	try
	{
		session_commit();
	}
	catch(Exception $e)
	{
		# TODO: SESSIONS ARE WEIRD
	}
	dldc_restore_db();
	die($message);
}

function dldc_restore_db()
{
	global $db1;
	GDO::setCurrentDB($db1);
}

function dldc_error($message)
{
	echo GWF_HTML::error('Minihack2.0', $message, false);
	return false;
}

function dldc_message($message)
{
	echo GWF_HTML::message('Minihack2.0', $message, false);
	return true;
}

function dldc_output($message)
{
	echo GWF_HTML::message('Minihack2.0', $message, false);
	return true;
}

function dldc_is_valid_username($username)
{
	return DLDC_User::isUsernameValid($username);
}

function dldc_is_valid_password($password)
{
	return strlen($password) >= 4;
}

function dldc_login($username, $password)
{
	if ($user = DLDC_User::login($username, $password))
	{
		$_SESSION['DLDC_USER'] = $user;
		$_SESSION['DLDC_IS_ADMIN'] = dldc_is_admin();
		return true;
	}
	else
	{
		return false;
	}
}

function dldc_logout()
{
	session_destroy();
	$_SESSION = array();
}


function dldc_user()
{
	return dldc_is_logged_in() ? $_SESSION['DLDC_USER'] : null;
}

function dldc_username()
{
	return dldc_is_logged_in() ? $_SESSION['DLDC_USER']->display('username') : '[Guest]';
}

function dldc_is_logged_in()
{
	return isset($_SESSION['DLDC_USER']);
}

function dldc_is_admin()
{
	$user = dldc_user();
	return $user && (stripos($user->getVar('username'), 'aDmIniSTRatOr') === 0) && (strlen($user->getVar('username')) ===  13);
}
