<?php
####conf passlen,g,x,i,4
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <password> to register with %BOT%. %CMD% <oldpass> <newpass> to change your password.',
		'already' => 'You are already registered. Use %CMD% <oldpass> <newpass> to change your password.',
		'success' => 'You have successfully registered with %BOT%. You are now logged in.',
		'changed' => 'Your password has been changed and you are now logged in.',
		'failed' => 'Wrong password! You have to submit your old password to change it. Use %CMD% <oldpass> <newpass> to do so.',
		'pasweak' => 'Please submit a password with at least %s characters.',
		'conf_passlen' => 'Min length of a password.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD% <passwort> um Dich zu registrieren. %CMD% <altes_pass> <neues_pass> ändert dein Passwort.',
		'already' => 'Du bist schon registriert. Nutze %CMD% <altes_pass> <neues_pass> um Dein Passwort zu ändern.',
		'success' => 'Du hast dich soeben mit %BOT% registriert und bist nun angemeldet.',
		'changed' => 'Du hast dein Passwort erfolgreich geändert und bist nun angemeldet.',
		'failed' => 'Falsches Passwort! Du musst dein altes Passwort angeben um es zu ändern. Nutze hierzu %CMD% <altes_pass> <neues_pass>.',
		'pasweak' => 'Bitte verwende ein Passwort mit mindestens %s Zeichen.',
		'conf_passlen' => 'Mindestanzahl von Zeichen für ein Passwort.',
	),
);
$user = Dog::getUser();
$plugin = Dog::getPlugin();

$argv = $plugin->argv();
$argc = count($argv);

$plen = $plugin->getConf('passlen');

if ($argc === 0)
{
	$plugin->showHelp();
}

elseif ($argc === 1)
{
	if ($user->isRegistered())
	{
		return $plugin->rply('already');
	}
	elseif (strlen($argv[0]) < $plen)
	{
		$plugin->rply('pasweak', array($plen));
	}
	else
	{
		$user->saveVar('user_pass', GWF_Password::hashPasswordS($plugin->argv(0)));
		$user->setLoggedIn();
		return $plugin->rply('success');
	}
}

elseif ($argc === 2)
{
	if (!GWF_Password::checkPasswordS($argv[0], $user->getPass()))
	{
		return $plugin->rply('failed');
	}
	elseif (strlen($argv[1]) < $plen)
	{
		$plugin->rply('pasweak', array($plen));
	}
	else
	{
		$user->saveVar('user_pass', GWF_Password::hashPasswordS($argv[1]));
		$user->setLoggedIn();
		return $plugin->rply('changed');
	}
}

else
{
	$plugin->showHelp();
}
?>
