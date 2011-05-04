<?php # Usage: %TRIGGER%mem. Show memory usage of the bot.
$mem = memory_get_usage(true);
$peak = memory_get_peak_usage(true);
$bot->reply(sprintf('Currently there are %s in use. Max memory peak was %s.', GWF_Upload::humanFilesize($mem, '1000'), GWF_Upload::humanFilesize($peak, '1000')));
?>