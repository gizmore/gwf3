<?php
# uid::cid::solve_date::1st_look::viewcount::options::time_taken::tries::username::challname::solvecount
# dog_wc_solvers('WC', '[WeChall]', 'https://www.wechall.net/index.php?mo=WeChall&me=API_ChallSolved&ajax=true&datestamp=%DATE%&no_session=true')
function dog_wc_solvers($key, $name, $url, $channels, $max_solvercount, $format)
{
	# Date we want to query
	$lastdate = GWF_Settings::getSetting('DOG_SOLVERS_DATE_'.$key, '');
	if (strlen($lastdate) !== 14)
	{
		$lastdate = date('YmdHis');
		GWF_Settings::setSetting('DOG_SOLVERS_DATE_'.$key, $lastdate);
	}
	$lastpair = GWF_Settings::getSetting('DOG_SOLVERS_PAIR_'.$key, '');
	
	# Query URL
	$url = str_replace(array('%DATE%'), array($lastdate), $url);
// 	echo $url.PHP_EOL;
	
	GWF_HTTP::setTimeout(3);
	GWF_HTTP::setConnectTimeout(2);
	if (false === ($content = GWF_HTTP::getFromURL($url)))
	{
		return;
	}
	GWF_HTTP::setTimeout();
	GWF_HTTP::setConnectTimeout();
	
// 	echo $content.PHP_EOL;
	
	# Nothing happened
	if ($content === '')
	{
		return;
	}
	
	$lines = explode("\n", $content);
	$changed = false;
	$badlines = 0;
	$latestdate = $lastdate;
	$firstpair = false;
	
	foreach ($lines as $line)
	{
// 		echo "$line\n";
		
		if ('' === ($line = trim($line)))
		{
			continue;
		}
		
		$thedata = explode('::', $line);
		if (count($thedata) !== 12)
		{
			$badlines++;
			echo 'Invalid line in dog_wc_solvers: '.$line.PHP_EOL;
			if ($badlines > 3)
			{
				echo "BAD URL IS: $url\n";
				return;
			}
			continue;
		}
		$badlines = 0;
		
		$thedata = array_map('unescape_csv_like', $thedata);
		
		# Fetch line
		# uid::cid::solve_date::1st_look::viewcount::options::time_taken::tries::username::challname::solvecount::url
		list($uid, $cid, $solvedate, $firstdate, $views, $options, $timetaken, $tries, $username, $challname, $solvercount, $challurl) = $thedata;
		
		if (strlen($solvedate) !== 14)
		{
			echo "Dateformat in $url is invalid: $solvedate\n";
			return false;
		}
		
		$latestdate = $solvedate;
		$pair = "$uid:$cid";

		if ($firstpair === false)
		{
			$firstpair = $pair;
		}
		
		if ($pair === $lastpair)
		{
			break;
		}

		if ($solvercount > $max_solvercount)
		{
			continue;
		}
		
		$msg = sprintf($format, $name, $username, $challname, $solvercount, $challurl);
		
		
		if (count($channels) === 0)
		{
			# To all servers in the main channel
			foreach (Dog::getServers() as $server)
			{
				$server instanceof Dog_Server;
				$channels = $server->getChannels();
				if (count($channels) > 0)
				{
					$channel = array_shift($channels);
					$channel = $channel->getName();
					$server->sendPRIVMSG($channel, $msg);
				}
			}
		}
		else 
		{
			# To all servers in matching channels
			foreach (Dog::getServers() as $server)
			{
				$server instanceof Dog_Server;
				$channels_now = $server->getChannels();
				foreach ($channels_now as $channel)
				{
					$channel instanceof Dog_Channel;
					$channel = $channel->getName();
					echo $channel.PHP_EOL;
					foreach ($channels as $c)
					{
						if (!strcasecmp($c, $channel))
						{
							$server->sendPRIVMSG($channel, $msg);
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
		GWF_Settings::setSetting('DOG_SOLVERS_DATE_'.$key, $latestdate);
		GWF_Settings::setSetting('DOG_SOLVERS_PAIR_'.$key, $firstpair);
	}

}

/* this is defined in Dog_WC_Forum.php */
if (!function_exists('unescape_csv_like')) {
	function unescape_csv_like($s)
	{
		return str_replace('\\:', ':', $s);
	}
}
?>