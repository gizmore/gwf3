<?php
### This is wechall html_head!

if(defined('WC_HTML_HEAD__DEFINED')) {
	return;
}

#####################################
### Init core templates and stuff ###
#####################################
require_once 'inc/_gwf_include.php';

GWF_Session::start(defined('GWF_SESSION_NOT_BLOCKING')?false:true);

GWF_Language::init();
GWF_HTML::init();

$_GET['mo'] = 'WeChall';
$_GET['me'] = 'Challenge';
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

# Doctype Shebang!
echo GWF_Doctype::xhtmlstrict();

$iso = GWF_Language::getCurrentISO();
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$iso.'" lang="'.$iso.'">'.PHP_EOL;

# HTML Header
echo GWF_Website::getHTMLHead();

# Include Needed Modules
//GWF_Module::getModule('Votes', true);
GWF_Module::loadModuleDB('Forum', true);
GWF_Module::getModule('WeChall', true)->onLoadLanguage();
require_once 'module/WeChall/WC_ChallSolved.php';
//GWF_ForumBoard::init(true);
# Body Start, see footer
echo '<body>';
$mb = (WC_HTML::wantFooter()) ? ' style="margin-bottom: -48px;"' : '';
?>
<div id="page_wrap">
