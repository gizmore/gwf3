<?php
if(defined('WC_HTML_HEAD__DEFINED')) { return; }

$_GET['mo'] = 'WeChall';
$_GET['me'] = 'Challenge';

require_once 'protected/config.php';
require_once '../gwf3.class.php';
$gwf = new GWF3(dirname(dirname(__FILE__).'../'), array(
	'init' => true, # Init?
	'bootstrap' => false, # Init GWF_Bootstrap?
	'website_init' => true, # Init GWF_Website?
	'autoload_modules' => true, # Load modules with autoload flag?
	'load_module' => true, # Load the requested module?
	'load_config' => false, # Load the config file? (DEPRECATED) # TODO: REMOVE
	'start_debug' => true, # Init GWF_Debug?
	'get_user' => true, # Put user into smarty templates?
	'do_logging' => true, # Init the logger?
	'log_request' => true, # Log the request?
	'blocking' => !defined('GWF_SESSION_NOT_BLOCKING'),
	'no_session' => false, # Suppress session creation?
	'store_last_url' => true, # Save the current URL into session?
	'ignore_user_abort' => true, # Ignore abort and continue the script on browser kill?
));

//if (false === ($wechall = GWF_Module::loadModuleDB('WeChall', true, true)))
//{
//	die('GWF3/WC5 not installed?');
//}

//$error = GWF_Module::startup();

if (defined('GWF_PAGE_TITLE')) {
	GWF_Website::setPageTitle(GWF_PAGE_TITLE);
	GWF_Website::setMetaDescr(GWF_PAGE_TITLE.' challenge on WeChall');
	GWF_Website::setMetaTags(GWF_PAGE_TITLE.', Challenge, WeChall');
}

# Include Needed Modules
//GWF_Module::getModule('Votes', true);
GWF_Module::loadModuleDB('Forum', true);
//GWF_Module::getModule('WeChall', true)->onLoadLanguage();
require_once GWF_CORE_PATH.'module/WeChall/WC_ChallSolved.php';
//GWF_ForumBoard::init(true);

$mb = (WC_HTML::wantFooter()) ? ' style="margin-bottom: -48px;"' : '';

echo GWF_Doctype::getDoctype(GWF_DEFAULT_DOCTYPE);

# HTML Header
//echo GWF_Website::getPagehead();
if (false === defined('NO_HEADER_PLEASE'))
{
	echo $gwf->onDisplayHead();# . '<div id="page_wrap">';
}
?>