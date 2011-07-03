<?php
#define GWF_WORKER_IP in your config!

if (defined('GWF_WORKER_IP'))
{
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if (GWF_WORKER_IP !== $ip)
	{
		$msg = 'Converting the database atm. should be back within 45 minutes.';
		# Use one of these:
		die(GWF_SITENAME.' is down for maintainance.<br/>'.$msg);
		define('GWF_WEBSITE_DOWN', $msg);
	}
}
?>