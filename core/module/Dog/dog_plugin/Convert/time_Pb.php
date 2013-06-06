<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<gwf_date>|<countrycode_iso1>]. Print the current bot-time, a gwf_date as uniox timestamp, or the current time in a country.',
		'bot' => 'The bot\'s time is %s %s. Unix timestamp: %s',
		'err_tz_stub' => 'I cannot parse timezones yet. I blame Hirsch.',
		'err_date' => 'Invalid gwf_date!',
		'out' => 'The date %s will have the unix timestamp of %d.',
	),
);
$plugin = Dog::getPlugin();
$message = $plugin->msg();
if ($message === '')
{
	$timezone = date('T');
	$gdo_date = GWF_Time::getDate(GWF_Date::LEN_SECOND);
	$plugin->rply('bot', array(GWF_Time::displayDate($gdo_date), $timezone, time()));
}

elseif (preg_match('/^[a-z]{2}$/i', $message))
{
	$plugin->rply('err_tz_stub');
}

elseif (preg_match('/^[0-9]{2,21}$/', $message))
{
	if (!GWF_Time::isValidDate($message, false, strlen($message), 100000))
	{
		$plugin->rply('err_date');
	}
	else
	{
		$plugin->rply('out', array(GWF_Time::displayDate($message), GWF_Time::getTimestamp($message)));
	}
}

else
{
	$plugin->showHelp();
}
?>
