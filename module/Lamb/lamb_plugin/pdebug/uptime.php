<?php # Usage: %TRIGGER%uptime. Print statistics about the bots uptime.
$now = microtime(true) - GWF_Settings::getSetting('_lamb3_startuptime');
//$now = GWF_Settings::getSetting('_lamb3_shutdowntime') - GWF_Settings::getSetting('_lamb3_startuptime');
$total = GWF_Settings::getSetting('_lamb3_uptime');
$total += $now;
$now = round($now);
$total = round($total);

$bot->reply(sprintf('This bot is running since %s. (Total runtime: %s)', GWF_Time::humanDuration($now), GWF_Time::humanDuration($total)));
?>
