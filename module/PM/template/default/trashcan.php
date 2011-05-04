<p><?php echo $tLang->lang('pi_trashcan'); ?></p>
<?php echo $tVars['pagemenu']; ?>
<?php 
$headers = array(
	array($tLang->lang('th_pm_options&1'), 'options&1', 'DESC'),
	array($tLang->lang('th_pm_date'), 'pm_date', 'DESC'),
	array($tLang->lang('th_pm_from'), 'T_B.user_name', 'ASC'),
	array($tLang->lang('th_pm_to'), 'T_A.user_name', 'ASC'),
	array($tLang->lang('th_pm_title'), 'pm_title', 'ASC'),
	array(),
);
$data = array();
$uid = GWF_Session::getUserID();
echo sprintf('<form id="gwf_pm_form" method="post" action="%s">', $tVars['form_action']);
//echo sprintf('<table>');
foreach ($tVars['pms'] as $pm)
{
	$pm instanceof GWF_PM;
//	$is_read = $pm->isOptionEnabled(GWF_PM::READ);
//	$is_sender = $pm->getSender()->getID() === $uid;
//	$is_deleted = $pm->getReceiver()->
//	$class =  $is_sender ? ($is_read ? 'gwf_pm_read' : 'gwf_pm_unread') : ($is_read ? 'gwf_pm_new' : 'gwf_pm_old');
	
	$data[] = array(
		sprintf('<span class="%s" />', $pm->getHTMLClass()),
		sprintf('%s', GWF_Time::displayDate($pm->getVar('pm_date'))),
		sprintf('%s', $pm->getSender()->display('user_name')),
		sprintf('%s', $pm->getReceiver()->display('user_name')),
		sprintf('%s', GWF_HTML::anchor($pm->getDisplayHREF(), $pm->getVar('pm_title'))),
		sprintf('<input type="checkbox" name="pm[%s]" />', $pm->getID()),
	);
}
$headers = GWF_Table::getHeaders2($headers, $tVars['sort_url']);
$btns = '<input type="submit" name="restore" value="'.$tLang->lang('btn_restore').'" />';
$raw_body = '<tr><td colspan="4"></td><td class="ri">'.$btns.'</td><td>'.'<input type="checkbox" onclick="gwfPMToggleAll(this.checked);"/>'.'</td></tr>';
echo GWF_Table::display2($headers, $data, $tVars['sort_url'], '', $raw_body);
//echo sprintf('</table>');
echo sprintf('</form>');

echo $tVars['form_empty'];
?>
