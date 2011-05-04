<?php
# May not call by browser?
# Actually it does not matter! :P
if (isset($_SERVER['REMOTE_ADDR'])) {
	die('Error 0915: Cronjob is called by www. Check GWF_SERVER_PATH.');
}

# Include Kernel
require_once 'inc/_gwf_include.php';

# Init
GWF_Language::initEnglish();
GWF_HTML::initCronjob();


# Get the modules.
if (false === ($modules = GWF_Module::loadModulesDB())) {
	die('GWF DATABASE IS NOT INSTALLED.'.PHP_EOL);
}


# Call Cronjobs
GWF_Website::cronjobs();
?>