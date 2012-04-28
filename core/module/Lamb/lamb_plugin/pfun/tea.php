<?php # Usage: %CMD% [<nickname>]. Virtually get some tea or give it to others. If the issuer is gizmore it means he wants to drink beer instead.
$bot = Lamb::instance();
$user = $bot->getCurrentUser();
$server = $bot->getCurrentServer();

if ($message === '')
{
	$target = $user->getName();
}
else
{
	$target = Common::substrUntil($message, ' ', $message);
}

$server->sendAction($origin, sprintf('hands %s a cup of hot tea.', $target));
?>
