<?php
GWF_Javascript::focusElementByName('term');

echo $tVars['form_q']; # quickform

# Start PMs
if (count($tVars['pms']) > 0)
{

$headers = array(
	array($tLang->lang('th_pm_options&1'), 'pm_options&1'),
	array($tLang->lang('th_pm_date'), 'pm_date'),
	array($tLang->lang('th_pm_from')), #, 'T_A.user_name'),
	array($tLang->lang('th_pm_to')), # 'T_B.user_name'),
	array($tLang->lang('th_pm_title'), 'pm_title'),
	array('<input type="checkbox" onclick="gwfPmToggleAll"/>'),
);
$uid = GWF_Session::getUserID();
$headers = GWF_Table::getHeaders2($headers, $tVars['sort_url']);

echo $tVars['pagemenu'];

echo sprintf('<form id="gwf_pm_form" method="post" action="%s">', $tVars['form_action']);

echo GWF_Table::start();
echo GWF_Table::displayHeaders($headers);
foreach ($tVars['pms'] as $pm)
{
	$pm instanceof GWF_PM;
	echo GWF_Table::rowStart();
	echo sprintf('<td><span class="%s" /></td>', $pm->getHTMLClass()).PHP_EOL;
	echo sprintf('<td>%s</td>', GWF_Time::displayDate($pm->getVar('pm_date'))).PHP_EOL;
	echo sprintf('<td>%s</td>', $pm->getSender()->display('user_name')).PHP_EOL;
	echo sprintf('<td>%s</td>', $pm->getReceiver()->display('user_name')).PHP_EOL;
	echo sprintf('<td>%s</td>', GWF_HTML::anchor($pm->getDisplayHREF($tVars['term']), $pm->getVar('pm_title'))).PHP_EOL;
	echo sprintf('<td><input type="checkbox" name="pm[%s]" /></td>', $pm->getID()).PHP_EOL;
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
echo '</form>'.PHP_EOL;

echo $tVars['pagemenu'];

}
# End PMs
?>
