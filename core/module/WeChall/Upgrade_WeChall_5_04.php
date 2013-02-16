<?php
function Upgrade_WeChall_5_04(Module_WeChall $module)
{
	GWF_Website::addDefaultOutput(GWF_HTML::message('WC5', "Warboxes can have flags now. (thx Steven)"));
	
	$back = '';
	
	# Kill Old Warbox mode bit
	$killbit = WC_Site::NO_V1_SCRIPTS;
	$module->includeClass('WC_Site');
	$sites = GDO::table('WC_Site');
	if (!$sites->update("site_options=site_options&$killbit"))
	{
		$back .= GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	
	$module->includeClass('WC_Warbox');
	$boxes = GDO::table('WC_Warbox');
	if (!$boxes->createColumn('wb_options'))
	{
		$back .= GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	
	return $back;
}
