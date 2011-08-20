<?php # 311 RPL_WHOISUSER
/**
 *Lamb_Log::debugCommand
	CMD: 311
	FROM: natalya.psych0tik.net
	ARGS: Lamb,gizmore,gizmore,E80A13.709772.D64F48.7BDAA1,*,1guessmoor
             "<nick> <user> <host> * :<real name>"# Whois reply
 
 */
//var_dump($args);
if ($args[3] === '*')
{
	$nickname = $args[1];
	if (false !== ($user = $server->getUser($nickname)))
	{
		$server->sendNotice($user->getName(), 'You just have been logged in by NickServ.');
	
		$user->setAutoLoginAttempt(0);
		
		$user->setLoggedIn(true);
	}
}
?>

