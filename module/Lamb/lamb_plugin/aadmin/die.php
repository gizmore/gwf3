<?php # Usage: %TRIGGER%die [optional quit message]. Will disconnect the bot from all servers, which makes the script stop too.
$bot instanceof Lamb;
if ($message === '') { $message = $user->getName().' used the die command.'; }
foreach ($bot->getServers() as $server)
{
	$server instanceof Lamb_Server;
	$server->quit($message);
	$server->disconnect();
}
die($message.PHP_EOL);
?>