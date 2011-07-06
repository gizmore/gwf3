<?php # Query wechall for user or site info. Usage: %CMD% <username|rank> || %CMD% !site <sitename> || %CMD% !sites <username> || %CMD% !<sitename> <username|rank>
$bot instanceof Lamb;
$user instanceof Lamb_User;
$server instanceof Lamb_Server;
if ($message === '') {
	$message = $user->getName();
}
$url = 'http://www.wechall.net/wechall.php?username='.urlencode($message);
if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
	$bot->reply('HTTP Response error');
	return;
}
$bot->reply($result);
?>