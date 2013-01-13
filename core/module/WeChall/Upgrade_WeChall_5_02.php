<?php
function Upgrade_WeChall_5_02(Module_WeChall $module)
{
	GWF_Website::addDefaultOutput(GWF_HTML::message('WC5', "Sites have hostname, port, reducescore and IP now. (thx epoch)"));
	
	$module->includeClass('WC_Site');
	$sites = GDO::table('WC_Site');
	
	if (!$sites->createColumn('site_warhost'))
	{
		return GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));		
	}
	if (!$sites->createColumn('site_warport'))
	{
		return GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	if (!$sites->createColumn('site_war_rs'))
	{
		return GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	if (!$sites->createColumn('site_war_ip'))
	{
		return GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));		
	}
	return '';
}
