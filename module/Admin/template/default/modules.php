<?php
$headers = array(
	array($tLang->lang('th_priority'), 'module_priority', 'ASC'),
	array($tLang->lang('th_move')),
	array($tLang->lang('th_name'), 'module_name', 'ASC'),
	array($tLang->lang('th_version_db')),
	array($tLang->lang('th_version_hd')),
	array($tLang->lang('th_install')),
	array($tLang->lang('th_basic')),
	array($tLang->lang('th_adv')),
);

$data = array();
foreach ($tVars['modules'] as $name => $d)
{
	$has_adv = is_string($d['admin_url']) && $d['admin_url'] !== '#'; 
	$module = $d['module'];
	$module instanceof GWF_Module;
	$vHD = sprintf('%0.2f', $module->getVersion());
	$vDB = sprintf('%0.2f', $module->getVersionDB());
	if (true === ($needInstall = $vHD !== $vDB)) {
		$gNeedInstall = true;
	}
	
	$data[] = array(
		$module->getPriority(),
		sprintf('<span class="gwf_nobiga"><a href="%s">[Up]</a><a href="%s">[Down]</a><a href="%s">[First]</a><a href="%s">[Last]</a></span>', 
			$d['up_url'], $d['down_url'], $d['first_url'], $d['last_url']
		),
		sprintf('<a href="%s"%s>%s</a>', $d['edit_url'], $module->isEnabled()?'':' style="color:#ff0000;"', $module->display('module_name')),
		$needInstall === true ? '<b style="color: #ff0000;">'.$vDB.'</b>' : $vDB,
		$vHD,
		sprintf('<a href="%s">%s</a>', $d['install_url'], $tLang->lang('btn_install')),
		$needInstall ? '' :  sprintf('<a href="%s">%s</a>', $d['edit_url'], $tLang->lang('btn_config')),
		!$needInstall && $has_adv ? sprintf('<a href="%s">%s</a>', htmlspecialchars($d['admin_url']), $tLang->lang('btn_admin_section')) : '',
	);
}

if (isset($gNeedInstall))
{
	echo GWF_Box::box($tLang->lang('install_info', array( Module_Admin::getInstallAllURL())));
}


echo GWF_Table::display($headers, $tVars['sort_url'], $data, $tVars['by'], $tVars['dir']);

echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.PHP_EOL;
echo GWF_Button::generic($tLang->lang('btn_install_all'), $tVars['href_install_all']);
echo '</div></div>'.PHP_EOL;
?>
