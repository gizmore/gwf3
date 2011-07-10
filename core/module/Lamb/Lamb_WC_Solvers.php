<?php

# uid::cid::solve_date::1st_look::viewcount::options::time_taken::tries::username::challname::solvecount
# lamb_wc_solvers('WC', '[WeChall]', 'https://www.wechall.net/index.php?mo=WeChall&me=API_ChallSolved&ajax=true&datestamp=%DATE%&no_session=true')

function lamb_wc_solvers($key, $name, $url, $channels=array())
{
	# Date we want to query
	$lastdate = GWF_Settings::getSetting('LAMB_SOLVERS_DATE_'.$key, '');
	if (strlen($lastdate) !== 14)
	{
		$lastdate = date('YmdHis');
		GWF_Settings::setSetting('LAMB_SOLVERS_DATE_'.$key, $lastdate);
	}
	
	# Query URL
	$url = str_replace(array('%DATE%'), array($lastdate), $url);
	
	//echo $url.PHP_EOL;
	
	GWF_HTTP::setTimeout(3);
	GWF_HTTP::setConnectTimeout(2);
	if (false === ($content = GWF_HTTP::getFromURL($url)))
	{
		return;
	}
	GWF_HTTP::setTimeout();
	GWF_HTTP::setConnectTimeout();
	
	//echo $content.PHP_EOL;
	
	# Nothing happened
	if ($content === '')
	{
		return;
	}
	
	$lines = explode("\n", $content);
	$changed = false;
	$badlines = 0;
	$latestdate = $lastdate;
	
	foreach ($lines as $line)
	{
		if ('' === ($line = trim($line)))
		{
			continue;
		}
		
		$thedata = explode('::', $line);
		if (count($thedata) !== 12)
		{
			$badlines++;
			echo 'Invalid line in lamb_wc_solvers: '.$line.PHP_EOL;
			if ($badlines > 3) {
				return;
			}
			continue;
		}
		$badlines = 0;
		
		$thedata = array_map('unescape_csv_like', $thedata);
		
		# Fetch line
		# uid::cid::solve_date::1st_look::viewcount::options::time_taken::tries::username::challname::solvecount::url
		list($uid, $cid, $solvedate, $firstdate, $views, $options, $timetaken, $tries, $username, $challname, $solvercount, $challurl) = $thedata;
		
		if (strlen($firstdate) !== 14) {
			echo "Dateformat in $url is invalid: $lastdate\n";
			return false;
		}
		
		if (intval($latestdate) <= intval($solvedate))
			$latestdate = intval($solvedate) + 1;

		
		$lamb = Lamb::instance();
		# Output message
		$msg = sprintf("%s \x02%s\x02 has just solved \x02%s\x02. This challenge has been solved %d times. (https://www.wechall.net/%s)", $name, $username, $challname, $solvercount, $challurl);

		
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
					echo $channel.PHP_EOL;
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
		GWF_Settings::setSetting('LAMB_SOLVERS_DATE_'.$key, $latestdate);
	}

}

/* this is defined in Lamb_WC_Forum.php */
if (!function_exists('unescape_csv_like')) {
	function unescape_csv_like($s)
	{
		return str_replace('\\:', ':', $s);
	}
}
?>