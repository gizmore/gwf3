<?php
####conf retryout,u,l,i,7
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <password>. Logs you in. ',
		'already' => 'You are already logged in, maybe by NickServ?',
		'not_reg' => 'You are not registered. Try %T%register <password> in private first.',
		'paswrng' => 'Your password is wrong. This incident is beeing reported.',
		'wait' => 'Please wait %s and try again.',
		'logedin' => 'Welcome back! You are now logged in.',
		'conf_passlen' => 'Specifies the minimum password length in number of characters.',
		'conf_retryout' => 'Specifies the timeout between two consecutive login attempts.',
	),
);
$plugin = Dog::getPlugin();
$user = Dog::getUser();
$argv = $plugin->argv();
$wait = $plugin->getConf('retryout');
$uid = $user->getID();
$t = microtime(true);

# Attmepts
global $DOG_RLOGIN_ATTEMPTS;
if (!isset($DOG_RLOGIN_ATTEMPTS)) $DOG_RLOGIN_ATTEMPTS = array();
# TODO: Cleanup attempts.

if (count($argv) !== 1)
{
	$plugin->showHelp();
}
elseif ($user->isLoggedIn())
{
	$plugin->rply('already');
}
elseif (!$user->isRegistered())
{
	$plugin->rply('not_reg');
}
elseif (isset($DOG_RLOGIN_ATTEMPTS[$uid]) && ($DOG_RLOGIN_ATTEMPTS[$uid] > ($t-$wait)))
{
	$duration = round($wait - ($t - $DOG_RLOGIN_ATTEMPTS[$uid]) + 0.5);
	$plugin->rply('wait', array(GWF_Time::humanDuration($duration)));
}
elseif (!GWF_Password::checkPasswordS($argv[0], $user->getPass()))
{
	$DOG_RLOGIN_ATTEMPTS[$uid] = $t;
	$plugin->rply('paswrng');
}
else
{
	$user->setLoggedIn();
	$plugin->rply('logedin');
}
?>
