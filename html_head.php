<?php
### This is wechall html_head!

define('GWF_DEBUG_TIME_START', microtime(true));

if(defined('WC_HTML_HEAD__DEFINED')) { return; }

#####################################
### Init core templates and stuff ###
#####################################
require_once 'inc/_gwf_include.php';

$_GET['mo'] = 'WeChall';
$_GET['me'] = 'Challenge';
GWF_Website::init(dirname(__FILE__), !defined('GWF_SESSION_NOT_BLOCKING'));

GWF_Module::autoloadModules();

if (false === ($wechall = GWF_Module::loadModuleDB('WeChall', true)))
{
	die('GWF3/WC5 not installed?');
}

//$error = GWF_Module::startup();

if (defined('GWF_PAGE_TITLE')) {
	GWF_Website::setPageTitle(GWF_PAGE_TITLE);
	GWF_Website::setMetaDescr(GWF_PAGE_TITLE.' challenge on WeChall');
	GWF_Website::setMetaTags(GWF_PAGE_TITLE.', Challenge, WeChall');
//	GWF_Website::addJavascriptInline('setTimeout("var e = document.getElementById(\'answer\'); if (e!==null) { e.focus(); }", 1000);');
}

# Include Needed Modules
//GWF_Module::getModule('Votes', true);
GWF_Module::loadModuleDB('Forum', true);
GWF_Module::getModule('WeChall', true)->onLoadLanguage();
require_once 'module/WeChall/WC_ChallSolved.php';
//GWF_ForumBoard::init(true);

$mb = (WC_HTML::wantFooter()) ? ' style="margin-bottom: -48px;"' : '';

GWF_Doctype::setDoctype('xhtmlstrict');

# HTML Header
echo GWF_Website::getHTMLHead() . '<body><div id="page_wrap">';
