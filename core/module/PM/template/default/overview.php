<h1>
	<?php echo GWF_Button::options($tVars['href_options'], $tLang->lang('btn_options')); ?>
	<?php echo GWF_Button::search($tVars['href_search'], $tLang->lang('btn_search')); ?>
	<?php echo GWF_Button::trashcan($tVars['href_trashcan'], $tLang->lang('btn_trashcan')); ?>
	<?php echo $tLang->lang('pt_pm'); ?>
</h1>

<div>
	<div class="fl"><?php echo $tVars['form_new_folder']; ?></div>
	<div class="fl"><?php echo $tVars['new_pm']; ?></div>
	<div class="cl"></div>
</div>

<div class="fl" id="gwf_pm_folders">
	<?php echo $tVars['folders']; ?>
</div>

<div class="oa" id="gwf_pms">	
<?php 
$headers = array(
	array($tLang->lang('th_pm_options&1'), 'options&1', 'DESC'),
	array($tLang->lang('th_pm_date'), 'pm_date', 'DESC'),
	array($tLang->lang('th_pm_from'), 'T_B.user_name', 'ASC'),
	array($tLang->lang('th_pm_to'), 'T_A.user_name', 'ASC'),
	array($tLang->lang('th_pm_title'), 'pm_title', 'ASC'),
	array('<input type="checkbox" onclick="gwfPMToggleAll(this.checked);"/>'),
);
$headers = GWF_Table::getHeaders2($headers, $tVars['sort_url']);
$uid = GWF_Session::getUserID();

if (count($tVars['pms']) > 0)
{
	echo $tVars['pagemenu'];
	echo sprintf('<form id="gwf_pm_form" method="post" action="%s">', $tVars['form_action']);
	echo GWF_Table::start();
	echo '<thead><tr><th colspan="5">'.$tVars['folder']->display('pmf_name').'</th></tr></thead>'.PHP_EOL;
	foreach ($tVars['pms'] as $pm)
	{
		$pm instanceof GWF_PM;
		echo GWF_Table::rowStart();
		$reply = GWF_Button::reply($pm->getReplyHREF(), $tLang->lang('btn_reply'));
		$fromid = $pm->getFromID();
		$toid = $pm->getToID();
		$own = $fromid===$toid ? GWF_Session::getUser()->displayProfileLink() : '';
		$href = $pm->getDisplayHREF();
		$html_class = $pm->getHTMLClass();
		$icon = sprintf('<a href="%s" class="gwf_pm_icon %s" title="%s" ></a>', $href, $html_class, $tLang->lang($html_class));
//		echo GWF_Table::column();
		echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, GWF_Time::displayDate($pm->getVar('pm_date'))), 'gwf_date');
		echo GWF_Table::column($uid === $fromid ? $own : $reply.sprintf('%s', $pm->getSender()->displayProfileLink()));
		echo GWF_Table::column($uid === $toid ? $own : $reply.sprintf('%s', $pm->getReceiver()->displayProfileLink()));
		echo GWF_Table::column("$icon ".GWF_HTML::anchor($href, $pm->getVar('pm_title')));
		echo GWF_Table::column(sprintf('<input type="checkbox" name="pm[%s]" />', $pm->getID()));
		echo GWF_Table::rowEnd();
	}
	echo GWF_Table::rowStart();
	echo GWF_Table::column(sprintf('<input type="checkbox" name="toggle" onclick="gwfPMToggleAll(this.checked);" />'), 'ri', 5);
	echo GWF_Table::rowEnd();
	$headers = GWF_Table::getHeaders2($headers, $tVars['sort_url']);
	$btns =
		'<input type="submit" name="delete" value="Delete" />'.
		$tVars['folder_select'].
		'<input type="submit" name="move" value="Move" />';
	$raw_body = '<tr><td colspan="5">'.$btns.'</td></tr>';
	echo $raw_body;
	echo GWF_Table::end();
	echo sprintf('</form>');
	echo $tVars['pagemenu'];
}
?>
</div>

<div class="cb"></div>