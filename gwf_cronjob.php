<?php
# May not call by browser
if (isset($_SERVER['REMOTE_ADDR']))
{
	die('Error 0915: Cronjob is called by www. Check GWF SERVER PATH.');
}

# Include Kernel
require_once 'gwf3.class.php';
# Init
$gwf = new GWF3(__FILE__, true, false);

# Call Cronjobs
GWF_Website::cronjobs();
?>