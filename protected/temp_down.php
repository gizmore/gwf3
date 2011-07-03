<?php
#define GWF_WORKER_IP in your config!

if (defined('GWF_WORKER_IP'))
{
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if (GWF_WORKER_IP !== $ip)
	{
		# Use one of these:
		die(GWF_SITENAME.' is down for maintainance.<br/>'.GWF_DOWN_REASON);
		define('GWF_WEBSITE_DOWN', GWF_DOWN_REASON);
	}
}
?>