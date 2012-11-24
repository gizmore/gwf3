<?php
function dog_svn_info($key, $repo, $user='', $pass='', $displayurl='', $channels=array())
{
	$keyshort = $key;
	$key = 'DOG_SVNINFO_REVISION_'.$key;
	$svninfo = new GWF_SvnInfo();

	$svninfo->setRepository($repo, $user, $pass);

	if (0 == ($currentRevision = $svninfo->getCurrentRevision()))
	{
		return Dog_Log::debug('Fetching current revision failed.');
	}
	
	$lastRevision = GWF_Settings::getSetting($key, $currentRevision);
	
	if ($currentRevision <= $lastRevision)
	{
		GWF_Settings::setSetting($key, $currentRevision);
		return;
	}

	$svnlog = $svninfo->getLog($lastRevision+1, $currentRevision);

	foreach ($svnlog as $entry)
	{
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
			foreach (DOG::getServers() as $server)
			{
				$server instanceof Dog_Server;
				$channels = $server->getChannels();
				if (count($channels) > 0)
				{
					$channel = array_shift($channels);
					$channel = $channel->getVar('chan_name');
					$server->sendPRIVMSG($channel, $msg);
				}
			}
		}
		else
		{
			# To all servers in matching channels
			foreach (DOG::getServers() as $server)
			{
				$server instanceof Dog_Server;
				$channels_now = $server->getChannels();

				foreach ($channels_now as $channel)
				{
					$channel instanceof Dog_Channel;
					$channel = $channel->getName();

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
	}

	GWF_Settings::setSetting($key, $currentRevision);
}
?>
