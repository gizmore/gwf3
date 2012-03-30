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
echo sprintf('<form id="gwf_pm_form" method="post" action="%s">', htmlspecialchars($tVars['form_action']));
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['pms'] as $pm)
{
	$pm instanceof GWF_PM;
	echo GWF_Table::rowStart();
	echo GWF_Table::column('<span class="'.$pm->getHTMLClass().'" ></span>');
	echo GWF_Table::column(GWF_Time::displayDate($pm->getVar('pm_date')));
	echo GWF_Table::column($pm->getSender()->display('user_name'));
	echo GWF_Table::column($pm->getReceiver()->display('user_name'));
	echo GWF_Table::column(GWF_HTML::anchor($pm->getDisplayHREF(), $pm->getVar('pm_title')));
	echo GWF_Table::column(sprintf('<input type="checkbox" name="pm[%s]" />', $pm->getID()));
//	$is_read = $pm->isOptionEnabled(GWF_PM::READ);
//	$is_sender = $pm->getSender()->getID() === $uid;
//	$is_deleted = $pm->getReceiver()->
//	$class =  $is_sender ? ($is_read ? 'gwf_pm_read' : 'gwf_pm_unread') : ($is_read ? 'gwf_pm_new' : 'gwf_pm_old');
	
//	$data[] = array(
//		sprintf('<span class="%s" />', $pm->getHTMLClass()),
//		sprintf('%s', GWF_Time::displayDate($pm->getVar('pm_date'))),
//		sprintf('%s', $pm->getSender()->display('user_name')),
//		sprintf('%s', $pm->getReceiver()->display('user_name')),
//		sprintf('%s', GWF_HTML::anchor($pm->getDisplayHREF(), $pm->getVar('pm_title'))),
//		sprintf('<input type="checkbox" name="pm[%s]" />', $pm->getID()),
//	);
}
echo GWF_Table::end();

echo sprintf('</form>');

echo $tVars['form_empty'];
?>
