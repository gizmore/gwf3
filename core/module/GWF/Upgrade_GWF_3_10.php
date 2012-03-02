<?php
function Upgrade_GWF_3_10(Module_GWF $module)
{
	echo GWF_HTML::message('GWF', 'Triggering Upgrade_GWF_3_10');
	echo GWF_HTML::message('GWF', 'Removing some outdated module vars ...');
	
	echo GWF_HTML::message('GWF', 'Removing log_404');
	if (false === GWF_ModuleLoader::removeModuleVar($module, 'log_404'))
	{
		return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	
	echo GWF_HTML::message('GWF', 'Removing mail_404');
	if (false === GWF_ModuleLoader::removeModuleVar($module, 'mail_404'))
	{
		return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	
	return '';
}
?>
