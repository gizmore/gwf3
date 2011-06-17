<?php
$client = false;
if ($tVars['client'] !== false)
{
	$client = $tVars['client'];
	$client instanceof GWF_Client;
	$token = $client->getVar('vsc_token');
	echo '<p>'.$tLang->lang('info_purchased', array( htmlspecialchars($client->hrefZipper()), $token)).'</p>'.PHP_EOL;

	$server_url = trim(Common::getAbsoluteURL('', true), ' /');
	
	echo GWF_Table::start();
	echo GWF_Table::rowStart();
	echo sprintf('<td>%s</td><td>%s</td>', $tLang->lang('vccfg_server'), $server_url);
	echo GWF_Table::rowEnd();
	echo GWF_Table::rowStart();
	echo sprintf('<td>%s</td><td>%s</td>', $tLang->lang('vccfg_token'), $token);
	echo GWF_Table::rowEnd();
	echo GWF_Table::end();
}

$headers = array(
	array(),
	array($tLang->lang('th_module_name')),
	array($tLang->lang('th_module_price')),
	array($tLang->lang('th_module_deps')),
	array($tLang->lang('th_module_methods')),
);

echo GWF_Form::start();
echo GWF_Table::start();
echo GWF_Table::displayHeaders2($headers);
foreach ($tVars['modules'] as $module)
{
	$module instanceof GWF_Module;

	// Method enumeration
	$strMethods = '';
	$methods = $module->getMethods();
	if (count($methods) === 0) {
		continue;
	}
	foreach ($methods as $method)
	{
		$method instanceof GWF_Method;
		$strMethods .= ', '.$method->getMethodName();
	}
	$strMethods = substr($strMethods, 2);
	// methods enumerated
	
	echo GWF_Table::rowStart();

	$price = $module->getPrice();
	
	if ($client !== false)
	{
		$checked = $client->ownsModule($module->getVar('module_name'));
	}
	else
	{
		$checked = isset($_POST['purchase']) ? isset($_POST['mod'][$module->getName()]) : $module->getPrice() == 0;
	}
	
	echo sprintf('<td>%s</td>', GWF_Form::checkbox(sprintf('mod[%s]', $module->getName()), $checked));
	echo sprintf('<td>%s</td>', $module->display('module_name'));
	echo sprintf('<td>%s</td>', Module_Payment::displayPrice($price));
	echo sprintf('<td>%s</td>', implode(', ', array_keys($module->getDependencies())));
	echo sprintf('<td>%s</td>', $strMethods);
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();


// Design table
$headers = array(
	array(),
	array($tLang->Lang('th_design_name')),
	array($tLang->Lang('th_design_price')),
);
echo GWF_Table::start();
echo GWF_Table::displayHeaders2($headers);
foreach ($tVars['designs'] as $design => $price)
{
	if ($client !== false)
	{
		$checked = $client->ownsDesign($design);
	}
	else
	{
		$checked = isset($_POST['purchase']) ? isset($_POST['design'][$design]) : $price == 0;
	}
	echo GWF_Table::rowStart();
	echo sprintf('<td>%s</td>', GWF_Form::checkbox(sprintf('design[%s]', $design), $checked));
	echo sprintf('<td>%s</td>', $design);
	echo sprintf('<td>%s</td>', Module_Payment::displayPrice($price));
	echo GWF_Table::rowEnd();
	
}

echo GWF_Table::end();


echo '<div class="gwf_buttons_outer">'.PHP_EOL;
echo '<div class="gwf_buttons">'.PHP_EOL;
echo GWF_Form::submit('purchase', $tLang->lang('btn_purchase')).PHP_EOL;
echo '</div>'.PHP_EOL;
echo '</div>'.PHP_EOL;

echo GWF_Form::end();

?>