<?php
#$workerIP = '192.168.0.4'; # <-- Set Down here
if (isset($workerIP))
{
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if ($workerIP !== $ip)
	{
		$msg = 'Converting the database atm. should be back within 45 minutes.';
		# Use one of these:
		die(GWF_SITENAME.' is down for maintainance.<br/>'.$msg);
		define('GWF_WEBSITE_DOWN', $msg);
	}
}
?>