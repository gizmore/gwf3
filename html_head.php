<?php
### This is wechall html_head!

if(defined('WC_HTML_HEAD__DEFINED')) { return; }

require_once 'gwf3.class.php';

$_GET['mo'] = 'WeChall';
$_GET['me'] = 'Challenge';

$gwf = new GWF3(false, false, false);
$gwf->onInit(dirname(__FILE__), !defined('GWF_SESSION_NOT_BLOCKING'));
$gwf->onAutoloadModules();

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
echo $gwf->onDisplayHead() . '<div id="page_wrap">';