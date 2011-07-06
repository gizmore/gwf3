	<?php echo GWF_Table::start('fl'); ?>
	<?php #$m = $tVars['module']; $m instanceof Module_Admin;
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
//		$class = $installed || $enabled ? 'gwf_mod_enabled' : 'gwf_mod_disabled';

		$href = $installed ? $d['edit_url'] : $d['install_url'];
//		$basicLink = $installed ? GWF_HTML::anchor($d['edit_url'], $tLang->lang('btn_edit', array( $name)) : GWF_HTML::anchor($d['install_url'], $tLang->lang('btn_install')));
		$advLink = $m->hasAdminSection() ? sprintf('<a href="%s">%s</a>', $d['admin_url'], $admin_sect) : '';
		echo sprintf('<tr><td align="right"><a href="%s">%s</a></td><td>%s</td></tr>', $href, $name, $advLink);
	}
	echo GWF_Table::end();
	?>

<div class="oa">
<?php
$module = $tVars['cfgmodule'];
if (false !== ($error = $module->checkDependencies())) {
	echo $error;
}
$methods = $module->getAllMethods();
if (count($methods) > 0)
{
	echo GWF_HTML::div($tLang->lang('info_methods', array( count($methods))));
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

<?php
$mtables = $module->getDatabaseTables();
echo sprintf('<p>%s</p>', $tLang->lang('pi_install', array( $module->display('module_name'), count($mtables), implode(', ', $mtables))));

echo $tVars['form_install'];
?>
</div>