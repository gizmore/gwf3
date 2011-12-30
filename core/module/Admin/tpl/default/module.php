<table class="fl">
	<?php
	$admin_sect = $tLang->lang('btn_admin_section');
	foreach ($tVars['modules'] as $d)
	{
		$m = $d['module']; $m instanceof GWF_Module;
		$name = $m->display('module_name');
		$installed = $m->isInstalled();
		$enabled = $m->isEnabled();
		if (!$installed) {
			$icon = 'unknown';
		} else {
			$icon = $enabled ? 'enabled' : 'disabled';
		}
		$href = $installed ? $d['edit_url'] : $d['install_url'];
		$advLink = $m->hasAdminSection() ? sprintf('<a href="%s">%s</a>', $d['admin_url'], $admin_sect) : '';
		echo sprintf('<tr><td align="right"><a href="%s">%s</a></td><td>%s</td></tr>', $href, $name, $advLink);
	}
	?>
</table>
<div class="oa">
<?php
$module = $tVars['cfgmodule'];
if (false !== ($error = GWF_ModuleLoader::checkModuleDependencies($module))) {
	echo $error;
}
$methods = GWF_ModuleLoader::getAllMethods($module);
if (count($methods) > 0)
{
	printf('<div class="box box_c">%s</div>', $tLang->lang('info_methods', array(count($methods))));
	foreach ($methods as $method)
	{
		$method instanceof GWF_Method;
		if (false !== ($error = $method->checkDependencies())) {
			echo $error;
		}
	}
}
?>
<?php
if ('cfgg_info' !== ($general = $module->lang('cfgg_info'))) {
	echo sprintf('<div>%s</div>', $general);
}
?>
<?php echo $tVars['form']; ?>
<?php echo $tVars['form_install']; ?>
</div>
<div class="cl"></div>
