<?php
/**
 * This file is part of the Lamb2 IRC Bot.
 * @author gizmore
 */

# Date we want to query
$date = GWF_Settings::getSetting('WC_FORUM_DATE', date('YmdH0000'));
# We already know these threads for the current data stored
$known = GWF_Settings::getSetting('WC_FORUM_LAST', ',');

# Set output channel
$server instanceof Lamb_Server;
$channels = $server->getChannels();
$channel = array_shift($channels);
$channel = $channel->getVar('chan_name');

# Query URL
$url = sprintf('http://www.wechall.net/nimda_forum.php?datestamp=%s&limit=5', $date);
if (false === ($content = GWF_HTTP::getFromURL($url))) {
	return;
}

# Nothing happened
if ($content === '') {
	return '';
}

$latest_date = $date;
$new_known = $known;
$lines = explode("\n", $content);
foreach ($lines as $line)
{
	if ('' === ($line = trim($line))) {
		continue;
	}
	
	# Fetch line
	list($threadid, $lastdate, $lock, $url, $username, $title) = explode('::', $line);
	
	# Duplicate output?
	if ( ($lastdate === $date) && (strpos($known, ','.$threadid.',') !== false) ) {
		continue;
	}
	
	# Is it private?
	$lock = $lock === '0' ? '' : ' locked';
	
	# does the date change?
	if ($latest_date !== $lastdate) {
		$latest_date = $lastdate;
		$new_known = ',';
	}
	
	# Mark this thread as known for this datestamp
	$new_known .= $threadid.',';
	
	# Output message
	if ($lock === ' locked') {
		$server->sendPrivmsg($channel, sprintf('[WeChall-Forum] New%s post: %s', $lock, $url));
	} else {
		$server->sendPrivmsg($channel, sprintf('[WeChall-Forum] New post by %s in %s: %s', $username, $title, $url));
	}
}

# Save state
GWF_Settings::setSetting('WC_FORUM_DATE', $lastdate);
GWF_Settings::setSetting('WC_FORUM_LAST', $new_known);
?>