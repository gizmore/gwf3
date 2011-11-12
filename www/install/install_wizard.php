<?php
chdir('../'); # to www

#####################################
### Try to find GWF automagically ###
#####################################
$gwf_path = '';
$inc_path = '../:'.get_include_path();
foreach (explode(':', $inc_path) as $path)
{
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
else # We have core :)
{
	require_once $gwf_path.'gwf3.class.php';
}

if (!GWF_IP6::isLocal()) 
{
	if ($_SERVER['REMOTE_ADDR'] !== 'your.ip.here')
	{
		die(sprintf('You are not admin in %s line %s.', __FILE__, __LINE__));
	}
}

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

require_once GWF_CORE_PATH.'inc/install/install.php';
