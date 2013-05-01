<?php # Usage: %CMD%. Show version of the bot.
$console = 'console';
$blocking = LAMB_BLOCKING_IO  ? 'blocking-io' : 'non-blocking-io';
$bot->reply(sprintf('%s runs Lamb version %s - %s - %s. %s %s - PHP %s - Time is %s.', LAMB_OWNER, LAMB_VERSION, $console, $blocking, php_uname('s'), php_uname('r'), PHP_VERSION, date('H:i:s')));
?>