<?php
$headers = array(
	array($tLang->lang('th_vs_id'), 'vs_id'),
	array($tLang->lang('th_vs_name'), 'vs_name'),
	array($tLang->lang('th_date'), 'vs_date'),
	array($tLang->lang('th_vs_expire_date'), 'vs_expire_date'),
	array($tLang->lang('th_vs_min'), 'vs_min'),
	array($tLang->lang('th_vs_max'), 'vs_max'),
	array($tLang->lang('th_vs_avg'), 'vs_avg'),
	array($tLang->lang('th_vs_sum'), 'vs_sum'),
	array($tLang->lang('th_vs_count'), 'vs_count'),
);

echo $tVars['page_menu'];

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers);
foreach ($tVars['votes'] as $vote)
{
	$vote instanceof GWF_VoteScore;
	$href_edit = $vote->getEditHREF();
	echo GWF_Table::rowStart();
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href_edit, $vote->getVar('vs_id')), 'gwf_num');
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href_edit, $vote->display('vs_name')));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

echo $tVars['page_menu'];
?>