<?php
define('GWF_CORE_VERSION', '3.01-2011.MAY.04');

# Get the config
if (!defined('GWF_HAVE_CONFIG'))
{
	if (!defined('GWF_CONFIG_NAME')) { define('GWF_CONFIG_NAME', 'protected/config.php'); }
	require_once GWF_CONFIG_NAME;
	define('GWF_HAVE_CONFIG', 1);
}

# Lang Web Root
if (isset($_SERVER['REQUEST_URI']))
{
	if (preg_match('#^'.GWF_WEB_ROOT_NO_LANG.'([a-z]{2}/)#', $_SERVER['REQUEST_URI'], $matches)) {
		if ($matches[1] === 'pm/') {
			define('GWF_WEB_ROOT', GWF_WEB_ROOT_NO_LANG);
		} else {
			define('GWF_WEB_ROOT', GWF_WEB_ROOT_NO_LANG.$matches[1]);
		}
	} else {
		define('GWF_WEB_ROOT', GWF_WEB_ROOT_NO_LANG);
	}
}
else
{
	define('GWF_WEB_ROOT', GWF_WEB_ROOT_NO_LANG);
}

# Require the Database
require_once 'inc/GDO/GDO.php';

# Require the util
require_once 'inc/util/Common.php';
require_once 'inc/_gwf_autoload.php';

# Enable the error handlers
GWF_Debug::enableErrorHandler();
?>
