<?php

function lamb_svn_info($key, $repo, $user='', $pass='', $displayurl='', $channels=array()) {
	$svninfo = new GWF_SvnInfo();

	$svninfo->setRepository($repo, $user, $pass);

	$currentRevision = $svninfo->getCurrentRevision();
	$lastRevision = GWF_Settings::getSetting('LAMB_SVNINFO_REVISION_'.$key, $currentRevision);

	if ($currentRevision <= $lastRevision) 
		return;

	
	//echo 'current revision: '.$currentRevision."\n";

	$svnlog = $svninfo->getLog($lastRevision, $currentRevision);

	foreach ($svnlog as $entry) {
		//$msg = 'rev'.$entry['version-name'].' - '.$entry['creator-displayname'].': '.$entry['comment'].' ('.$entry['date'].")";
		$msg = sprintf('[%s-SVN] New revision %s by %s: %s', 
				$key, 
				$entry['version-name'], 
				$entry['creator-displayname'],
				$entry['comment']
			);

		if ($displayurl != '')
			$msg .= ' ( '.str_replace('%REV%', $entry['version-name'], $displayurl).' )';

		if (count($channels) === 0) {
			# To all servers in the main channel
			foreach ($lamb->getServers() as $server) {
				$server instanceof Lamb_Server;
				$channels = $server->getChannels();
				
				if (count($channels) > 0) {
					$channel = array_shift($channels);
					$channel = $channel->getVar('chan_name');
					$server->sendPrivmsg($channel, $msg);
				}
			}
		} else {
			# To all servers in matching channels
			foreach ($lamb->getServers() as $server) {
				$server instanceof Lamb_Server;
				$channels_now = $server->getChannels();

				foreach ($channels_now as $channel) {
					$channel instanceof Lamb_Channel;
					$channel = $channel->getVar('chan_name');

					foreach ($channels as $c) {
						if (strtolower($c) === strtolower($channel))
							$server->sendPrivmsg($channel, $msg);
					}
				}
			}
		}
	}

	GWF_Settings::setSetting('LAMB_SVNINFO_REVISION_'.$key, $currentRevision);
}

?>