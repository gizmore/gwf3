<?php
function lamb_svn_info($key, $repo, $user='', $pass='', $displayurl='', $channels=array())
{
	$keyshort = $key;
	$lamb = Lamb::instance();
	$key = 'LAMB_SVNINFO_REVISION_'.$key;
	$svninfo = new GWF_SvnInfo();

	$svninfo->setRepository($repo, $user, $pass);

	if (false === ($currentRevision = $svninfo->getCurrentRevision()))
	{
		Lamb_Log::logDebug('Fetching current revision failed.');
		return;
	}
//	Lamb_Log::logDebug(sprintf('Polled the current revision from repositry: %d', $currentRevision));
	
	$lastRevision = GWF_Settings::getSetting($key, $currentRevision);
//	Lamb_Log::logDebug(sprintf('Polled the last known revision from database: %d', $lastRevision));
	
	if ($currentRevision <= $lastRevision)
	{
		GWF_Settings::setSetting($key, $currentRevision);
//		Lamb_Log::logDebug(sprintf('We are up to date!'));
		return;
	}

	$svnlog = $svninfo->getLog($lastRevision+1, $currentRevision);

	foreach ($svnlog as $entry)
	{
		//$msg = 'rev'.$entry['version-name'].' - '.$entry['creator-displayname'].': '.$entry['comment'].' ('.$entry['date'].")";
		$msg = sprintf('[%s] New revision %s by %s: %s', 
				$keyshort, 
				$entry['version-name'], 
				$entry['creator-displayname'],
				html_entity_decode($entry['comment'])
			);

		if ($displayurl != '')
		{
			$msg .= ' ( '.str_replace('%REV%', $entry['version-name'], $displayurl).' )';
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
	}

	GWF_Settings::setSetting($key, $currentRevision);
}

?>