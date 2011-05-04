<?php
# Time measurement
$t = microtime(true);
//$c1 = get_declared_classes();

# Include the core (always a good and safe idea)
require_once 'inc/_gwf_include.php';

# Init core
if (false === GWF_Website::init(dirname(__FILE__))) {
	die('GWF3 does not seem to be installed properly.');
}

# Autoload Modules :/
if (false === GWF_Module::autoloadModules()) {
	die('Cannot autoload modules. GWF not installed?');
}

# Load the module
if (false === ($module = GWF_Module::loadModuleDB(Common::getGetString('mo')))) {
	if (false === ($module = GWF_Module::loadModuleDB(GWF_DEFAULT_MODULE))) {
		die('No module found.');
	}
	$me = GWF_DEFAULT_METHOD;
}
else {
	$me = Common::getGetString('me', GWF_DEFAULT_METHOD);
}

//ob_start();
if ($module->isEnabled())
{
	# Execute the method
	$module->onInclude();
	$module->onLoadLanguage();
	$page = $module->execute($me);
	if (!isset($_GET['ajax'])) {
		$page = GWF_Website::getDefaultOutput().$page;
	}
}
else
{
	$page = GWF_HTML::err('ERR_MODULE_DISABLED', array($module->display('module_name')));
}
//$out = ob_get_contents();
//ob_end_clean();

# Commit the session
if (false !== ($user = GWF_Session::getUser())) {
	$user->saveVar('user_lastactivity', time());
}

GWF_Session::commit();

# Display the page
if (isset($_GET['ajax'])) {
	echo $page;
} else {
	echo GWF_Website::displayPage($page, GWF_Debug::getTimings($t));
}

//$c2 = get_declared_classes();
//var_dump($c2);
?>
