<?php # Convert a time string like '31-12-1999 23:59' to a unix timestamp.
if (false !== ($time = strtotime($message)))
{
	$bot->reply($time);
}
else
{
	$bot->reply('Could not parse your php strtotime parameter. Popular example: "31-12-1999 23:59"');
}
?>