<?php # Make Lamb autojoin all his default channels.

$bot = Lamb::instance();
$server = $bot->getCurrentServer();

foreach ($server->getAutoChannels() as $cname)
{
	if (false === $server->getChannel($cname))
	{
		$server->join($cname);
	}
}
?>
