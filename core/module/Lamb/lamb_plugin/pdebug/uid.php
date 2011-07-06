<?php # Usage: %CMD% [<username>]. Display the global unique userid of a user located on this server.
$server instanceof Lamb_Server;
if ($message === '') {
	$u = $user;
}
else {
	if (false === ($u = Lamb_User::getUser($server, $message))) {
		$bot->reply("The user $message seems unknown on this server.");
		return;
	}
}

$uid = $u->getID();
$sid = $server->getID();
$uname = $u->getName();
$bot->reply("The user $uname got the UID $uid and is located on server $sid.");
?>