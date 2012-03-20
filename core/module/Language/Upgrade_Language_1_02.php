<?php
function Upgrade_Language_1_02(Module_Language $module)
{
	echo GWF_HTML::message('GWF', 'Triggering Upgrade_Language_1_02');
	echo GWF_HTML::message('GWF', 'Removing some outdated module vars ...');
	echo GWF_HTML::message('GWF', 'Removing edit_time');
	if (false === GWF_ModuleLoader::removeModuleVar($module, 'edit_time'))
	{
		return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	return '';
}
?>