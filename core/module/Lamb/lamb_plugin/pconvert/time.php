<?php # Usage: %CMD% [<gwf_date>|<timezone>]. Print the current bot-time, a gwf_date, or the time of a timezone.

if ($message === '')
{
	$timezone = date('T');
	$gdo_date = GWF_Time::getDate(GWF_Date::LEN_SECOND);
	return $bot->reply(sprintf('The bot\'s time is %s %s. Unix timestamp: %s', GWF_Time::displayDate($gdo_date), $timezone, time()));
}

if (preg_match('/^[a-z]{3,4}$/i', $message))
{
	return $bot->reply('I cannot parse timezones yet. I blame Hirsch.');
}

if (preg_match('/^[0-9]{2,21}$/', $message))
{
	if (!GWF_Time::isValidDate($message, false, strlen($message), 100000))
	{
		return $bot->reply('Invalid gwf_date!');
	}
	return $bot->reply(sprintf('The date %s will have the unix timestamp of %d.', GWF_Time::displayDate($message), GWF_Time::getTimestamp($message)));
}

?>