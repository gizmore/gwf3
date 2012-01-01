<?php
$client = $tVars['client']; $client instanceof GWF_Client;
$icon_new = GWF_Button::add($tLang->lang('new'));
$icon_old = $tLang->lang('old');

# -- Module Table
$headers = array(
	array($tLang->Lang('th_module_name')),
	array($tLang->Lang('th_module_version')),
	array($tLang->Lang('th_module_price')),
	array($tLang->Lang('th_new_or_old')),
);
echo GWF_Table::start();
echo GWF_Table::displayHeaders2($headers);
foreach ($tVars['modules'] as $module)
{
	$module instanceof GWF_Module;
	
	$owns = $client->ownsModule($module->getVar('module_name'));
	$icon = $owns ? $icon_old : $icon_new;
	
	echo GWF_Table::rowStart();
	echo sprintf('<td>%s</td>', $module->display('module_name'));
	echo sprintf('<td>%s</td>', $module->getVersion());
	echo sprintf('<td>%s</td>', Module_Payment::displayPrice($module->getPrice()));
	echo sprintf('<td>%s</td>', $icon);
	
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

# -- Design Table
$headers = array(
	array($tLang->Lang('th_design_name')),
	array($tLang->Lang('th_design_price')),
	array($tLang->Lang('th_new_or_old')),
);
echo GWF_Table::start();
echo GWF_Table::displayHeaders2($headers);
foreach ($tVars['designs'] as $design => $price)
{
	$owns = $client->ownsDesign($design);
	$icon = $owns ? $icon_old : $icon_new;
	echo GWF_Table::rowStart();
	echo sprintf('<td>%s</td>', $design);
	echo sprintf('<td>%s</td>', Module_Payment::displayPrice($price));
	echo sprintf('<td>%s</td>', $icon);
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

?>