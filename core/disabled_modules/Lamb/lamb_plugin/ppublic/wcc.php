<?php
$bot instanceof Lamb;
$user instanceof Lamb_User;
$server instanceof Lamb_Server;
if ($message === '') {
	$message = $user->getName();
}
else {
	$message = Common::substrUntil($message, ' ');
}
$url = 'http://www.wechall.net/wechallchalls.php?username='.urlencode($message);
if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
	$bot->reply('HTTP Response error');
	return;
}
$bot->reply($result);
?>