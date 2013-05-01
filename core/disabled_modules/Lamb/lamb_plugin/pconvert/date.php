<?php # Usage: %CMD% [<timestamp>] [<timezone>]. Convert a unix timestamp to a date.
$bot = Lamb::instance();
$user = $bot->getCurrentUser();

if ($message === '')
{
	return $bot->getHelp('date');
}

$args = explode(' ', $message);

if (count($args) === 1)
{
	$args[] = 'CET';
}

if (count($args) !== 2)
{
	return $bot->getHelp('date');
}

$bot->reply(sprintf('Timestamp %s will be %s.', $args[0], GWF_Time::displayTimestamp($args[0], $user->getLangISO(), 'ERROR')));
?>
