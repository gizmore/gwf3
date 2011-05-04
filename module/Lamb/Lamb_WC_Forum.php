<?php
function lamb_wc_forum($key, $name, $url, $channels=array(), $limit=5, $onlygids=false, $skipgids=false)
{
	# Date we want to query
	$date = GWF_Settings::getSetting('LAMB_FORUM_DATE_'.$key, date('Ymd000000'));
	if (strlen($date) !== 14) {
		$date = date('Ymd000000');
	}
	
	# We already know these threads for the current data stored
	$known = GWF_Settings::getSetting('LAMB_FORUM_LAST_'.$key, ',');
	
	# Query URL
	$url = str_replace(array('%DATE%', '%LIMIT%'), array($date, $limit), $url);
	
//	echo $url.PHP_EOL;
	
	if (false === ($content = GWF_HTTP::getFromURL($url))) {
		return;
	}
	
//	echo $content.PHP_EOL;
	
	# Nothing happened
	if ($content === '') {
		return '';
	}
	
	$latest_date = $date;
	$new_known = $known;
	$lines = explode("\n", $content);
	$changed = false;
	$badlines = 0;
	foreach ($lines as $line)
	{
		if ('' === ($line = trim($line))) {
			continue;
		}
		
		$thedata = explode('::', $line);
		if (count($thedata) !== 6) {
			$badlines++;
			echo 'Invalid line in lamb_wc_forum: '.$line.PHP_EOL;
			if ($badlines > 3) {
				return;
			}
			continue;
		}
		$badlines = 0;
		
		$thedata = array_map('unescape_csv_like', $thedata);
		
		# Fetch line
		list($threadid, $lastdate, $lock, $url, $username, $title) = $thedata;
		
		if (strlen($lastdate) !== 14) {
			echo "Dateformat in $url is invalid: $lastdate\n";
			return false;
		}
		
		$gid = (int)$lock;
		
		if (is_array($onlygids))
		{
			if (!in_array($gid, $onlygids, true))
			{
//				echo "Not an only gid: $gid\n";
				continue;
			}
		}
		
		if (is_array($skipgids))
		{
			if (in_array($gid, $skipgids, true))
			{
//				echo "Skipped gid: $gid\n";
				continue;
			}
		}
		
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
		
		if (strpos($url, 'http') !== 0) {
			$url = 'http://'.$url;
		}
		
		$lamb = Lamb::instance();
		# Output message
		if ($lock === ' locked') {
			$msg = sprintf('%s New%s post: %s', $name, $lock, $url);
		} else {
			$msg = sprintf('%s New post by %s in %s: %s', $name, $username, $title, $url);
		}
		
		if (count($channels) === 0)
		{
			# To all servers in the main channel
			foreach ($lamb->getServers() as $server)
			{
				$server instanceof Lamb_Server;
				$channels = $server->getChannels();
				if (count($channels) > 0)
				{
					$channel = array_shift($channels);
					$channel = $channel->getVar('chan_name');
					$server->sendPrivmsg($channel, $msg);
				}
			}
		}
		else 
		{
			# To all servers in matching channels
			foreach ($lamb->getServers() as $server)
			{
				$server instanceof Lamb_Server;
				$channels_now = $server->getChannels();
				foreach ($channels_now as $channel)
				{
					$channel instanceof Lamb_Channel;
					$channel = $channel->getVar('chan_name');
//					echo $channel.PHP_EOL;
					foreach ($channels as $c)
					{
						if (strtolower($c) === strtolower($channel))
						{
							$server->sendPrivmsg($channel, $msg);
						}
					}
				}
			}
		}
		
		
		$changed = true;
	}
	
	# Save state
	if ($changed)
	{
		GWF_Settings::setSetting('LAMB_FORUM_DATE_'.$key, $lastdate);
		GWF_Settings::setSetting('LAMB_FORUM_LAST_'.$key, $new_known);
	}

}

function unescape_csv_like($s)
{
	return str_replace('\\:', ':', $s);
}
?>