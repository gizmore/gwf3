<?php
### This is wechall html_head!

if(defined('WC_HTML_HEAD__DEFINED')) { return; }

$_GET['mo'] = 'WeChall';
$_GET['me'] = 'Challenge';

//require_once 'protected/config.php';
//require_once 'GWF3.php';
//GWF3::init(dirname(__FILE__));
//GWF3::onDefineWebRoot();
//GWF_Session::start(true);
//GWF_Language::init();
//GWF_Website::init();
//GWF_Doctype::setDoctype(GWF_Doctype::HTML5);
//$user = GWF_Session::getUser();
//GWF_Log::init(($user===false?false:$user->getVar('user_name')), true, 'protected/logs');
//GWF_Debug::enableErrorHandler();
//GWF_Module::autoloadModules();

require_once 'protected/config.php';
require_once '../gwf3.class.php';
$gwf = new GWF3(dirname(__FILE__), array(
	'load_module' => true,
//	'get_user' => false,
	'blocking' => !defined('GWF_SESSION_NOT_BLOCKING'),
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

GWF_Doctype::setDoctype('xhtmlstrict');

# HTML Header
//echo GWF_Website::getPagehead();
echo $gwf->onDisplayHead();# . '<div id="page_wrap">';
?>