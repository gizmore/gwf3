<?php
# May not call by browser
if (isset($_SERVER['REMOTE_ADDR']))
{
	die('Error 0915: Cronjob is called by www. Check GWF SERVER PATH.');
}

# Include Kernel
require_once 'inc/_gwf_include.php';

# Init
GWF_Website::init(dirname(__FILE__, false, true));

# Get the modules.
if (false === ($modules = GWF_Module::autoloadModules()))
{
	die('GWF IS NOT INSTALLED.'.PHP_EOL);
}

# Call Cronjobs
GWF_Website::cronjobs();
?>