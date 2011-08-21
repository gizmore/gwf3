<?php # Is logged in
/*
:irc.gizmore.org 330 Lamb3 foo foo :is logged in as
=== UNKNOWN  EVENT ===
======================
Lamb_Log::debugCommand
CMD: 330
FROM: irc.gizmore.org
ARGS: Lamb3,foo,foo,is logged in as
======================
*/
$nickname = $args[2];
if ($nickname === $server->getBotsNickname())
{
	
}
elseif (false !== ($user = $server->getUser($nickname)))
{
	$server->sendNotice($user->getName(), 'You just have been logged in by NickServ.');
	$user->setAutoLoginAttempt(0);
	$user->setLoggedIn(true);
}
?>