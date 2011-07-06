<?php # Get the IP of the bot.
$bot instanceof Lamb;
$url = 'http://www.wechall.net/myip.php';
if (false === ($ip = GWF_HTTP::getFromURL($url))) {
	$bot->reply("$url seems down!");
	return;
}
if (!preg_match('/REMOTE_ADDR: ([0-9\\.]+)/', $ip, $matches)) {
	$bot->reply('Cannot parse 3rd party response for my own IP.');
}
else {
	$bot->reply("My IP address is $matches[1]");
}
?>
