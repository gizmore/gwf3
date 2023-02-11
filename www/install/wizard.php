<?php
chdir('../'); # to www

$worker_ip = 'YOUR.IP.GOES.HERE';

error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED);

#####################################
### Try to find GWF automagically ###
#####################################
$gwf_path = '';
$inc_path = '../:../GWF3/:'.get_include_path();
foreach (explode(':', $inc_path) as $path)
{
	$path = rtrim($path, '/\\');
	$fullpath = "{$path}/gwf3.class.php";
	if (is_file($fullpath) && is_readable($fullpath))
	{
		$gwf_path = "{$path}/";
		break;
	}
}
if ($gwf_path === '')
{
	die('Cannot autodetect GWF location!');
}

# Save detection to write it to index.php and cronjob.php
define('GWF_DETECT_PATH', $gwf_path);

########################
### Include GWF core ###
########################
require_once $gwf_path.'gwf3.class.php';

###################################
### Try to load the config file ###
###################################
$config_path = 'protected/config.php';
if (is_file($config_path) && is_readable($config_path))
{
	require_once $config_path;
}
else # Or autoconfig
{
	require_once GWF_CORE_PATH.'inc/install/GWF_AutoConfig.php';
	GWF_AutoConfig::configure();
}


######################
### Security check ###
######################
if (!GWF_IP6::isLocal()) 
{
	if ($_SERVER['REMOTE_ADDR'] !== $worker_ip)
	{
		die(sprintf('You have no valid $worker_ip in %s line %s. Your current IP is %s', __FILE__, __LINE__, $_SERVER['REMOTE_ADDR']));
	}
}

######################
### Call Installer ###
######################
require_once GWF_CORE_PATH.'inc/install/install.php';
?>
