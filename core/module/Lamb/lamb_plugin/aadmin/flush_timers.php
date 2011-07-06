<?php
if (false === $bot->flushTimers())
{
	$bot->reply('Timers flushed with errorcode: false');
}
$bot->reply('Timers have been successfully flushed.');
?>