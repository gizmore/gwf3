<?php
if (isset($tVars['form_add'])) { echo $tVars['form_add']; }
if (isset($tVars['form_edit'])) { echo $tVars['form_edit']; }

$headers = array(
	array(),
	array($tLang->lang('th_wf_order'), 'wf_order'),
	array($tLang->lang('th_mov')),
	array($tLang->lang('th_wf_cat'), 'wf_cat'),
	array($tLang->lang('th_wf_title'), 'wf_title'),
	array($tLang->lang('th_wf_login'), 'wf_login'),
	array($tLang->lang('th_wf_flag')),
	array($tLang->lang('th_wf_status')),
);

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers);
foreach ($tVars['flags'] as $flag)
{
	$flag instanceof WC_Warflag;
	echo GWF_Table::rowStart();
	$edit = GWF_Button::edit($flag->hrefEdit());
	echo GWF_Table::column($edit);
	echo GWF_Table::column($flag->getVar('wf_order'), 'gwf_num');
	echo GWF_Table::column('^<br/>v', 'gwf_num');
	echo GWF_Table::column($flag->display('wf_cat'));
	echo GWF_Table::column($flag->display('wf_title'));
	echo GWF_Table::column($flag->display('wf_login'));
	echo GWF_Table::column($flag->display('wf_flag'));
	echo GWF_Table::column($flag->display('wf_status'));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

echo GWF_Button::wrapStart();
echo GWF_Button::add($tLang->lang('btn_add_warflag'), $tVars['href_add']);
echo GWF_Button::wrapEnd();
?>