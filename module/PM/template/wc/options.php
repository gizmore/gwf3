<?php echo WC_HTML::accountButtons(); ?>
<?php echo GWF_Button::generic($tLang->lang('btn_auto_folder'), $tVars['href_auto_folder']); ?>
<?php echo $tVars['form']; ?>

<?php
$headers = array(
	array($tLang->lang('th_user_name')),#, 'user_name', 'ASC'),
	array($tLang->lang('th_actions')),
);

$data = array();

foreach ($tVars['ignores'] as $uname)
{
	$del_href = GWF_WEB_ROOT.'index.php?mo=PM&me=Options&unignore='.urlencode($uname);
	$data[] = array(
		GWF_HTML::display($uname),
		GWF_Button::delete($del_href),
	);
}
$headers = GWF_Table::getHeaders2($headers, '');
echo GWF_Table::display2($headers, $data, '');
?>

<?php echo $tVars['form_ignore']; ?>
