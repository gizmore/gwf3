<?php # Usage: %CMD%. Print the current bot-time.
$timezone = date('T');
$gdo_date = GWF_Time::getDate(GWF_Date::LEN_SECOND);
$bot->reply(sprintf('The bot\'s time is %s %s. Unix timestamp: %s', GWF_Time::displayDate($gdo_date), $timezone, time()));
?>