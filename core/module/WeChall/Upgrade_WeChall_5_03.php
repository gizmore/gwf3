<?php
function Upgrade_WeChall_5_03(Module_WeChall $module)
{
	GWF_Website::addDefaultOutput(GWF_HTML::message('WC5', "Sites can have multiple warboxes now. (thx awe)"));
	
	$module->includeClass('WC_Site');
	$sites = GDO::table('WC_Site');
	
	$columns = array(
		'site_warport',
		'site_warhost',
		'site_war_rs',
		'site_war_ip',
// 		'site_war_wl',
// 		'site_war_bl',
// 		'site_wargroup',
	);
	
	$back = '';
	foreach ($columns as $column)
	{
		if (!$sites->dropColumn($column))
		{
			$back .= GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
		}
	}

	return $back;
}
