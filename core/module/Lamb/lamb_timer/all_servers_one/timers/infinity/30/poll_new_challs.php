<?php
$bot = Lamb::instance();
$url = "http://www.wechall.net/index.php?mo=WeChall&me=API_Site&no_session=1";
$result = GWF_HTTP::getFromURL($url);
$lines = preg_split('/\\n/', $result);

$map = array(
	'Revolution Elite' => '#RevolutionElite',
	'Hacker.org' => '#hacker.org',
	'Security Traps' => '#securitytraps',
	'Rankk' => '#pyramid',
);

foreach ($lines as $line)
{
	$data = explode('::', $line);
	if (count($data)===1) {
		continue;
	}
	foreach ($data as $i => $d) { $data[$i] = str_replace('\\:', ':', $d); }
	list($sitename, $class, $status, $url, $purl, $users, $links, $challs, $basescore, $avg, $score) = $data;
	
	if ($status !== 'up') {
		continue;
	}
	
	$setname = "LAMB_SITECC_$class";
	
	$old = GWF_Settings::getSetting($setname, 0);
	
	if ($old != $challs)
	{
		$amt = $challs - $old;
		if (abs($amt) > 1) {
			$message = sprintf('There are %d new challenges on %s ( %s ).', $amt, $sitename, $url);
		} else {
			$message = sprintf('There is %d new challenge on %s ( %s ).', $amt, $sitename, $url);
		}
		foreach ($bot->getServers() as $s)
		{
			$s instanceof Lamb_Server;
			$c = $s->getChannels();
			
			if (count($c) > 0)
			{
				$c = array_shift($c);
				$c instanceof Lamb_Channel;
//				echo $c->getName().': '.$message.PHP_EOL;
				$s->sendPrivmsg($c->getName(), $message);
			}
		}
		
		if (isset($map[$sitename]))
		{
			$chan = $map[$sitename];
			foreach ($bot->getServers() as $s)
			{
				$s instanceof Lamb_Server;
				foreach ($s->getChannels() as $c)
				{
					$c instanceof Lamb_Channel;
					if (!strcasecmp($c->getName(), $chan))
					{
						$s->sendPrivmsg($c->getName(), $message);
					}
				}
			}
		}
		
		GWF_Settings::setSetting($setname, $challs);
	}
}
?>