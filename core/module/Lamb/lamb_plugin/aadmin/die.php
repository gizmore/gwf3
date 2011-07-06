<?php # Usage: %CMD% [optional quit message]. Will disconnect the bot from all servers, which makes the script stop too.
$bot instanceof Lamb;
if ($message === '') { $message = $user->getName().' used the die command.'; }
foreach ($bot->getServers() as $server)
{
	$server instanceof Lamb_Server;
	$server->disconnect($message);
}
die("Lamb received .die command: {$message}\n");
?>