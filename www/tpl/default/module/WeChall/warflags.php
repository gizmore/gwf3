<?php
if (isset($tVars['form_add'])) { echo $tVars['form_add']; }
if (isset($tVars['form_edit'])) { echo $tVars['form_edit']; }

$headers = array(
	array(),
	array($tLang->lang('th_wf_order'), 'wf_order'),
	array($tLang->lang('th_mov')),
	array($tLang->lang('th_wf_cat'), 'wf_cat'),
	array($tLang->lang('th_wf_score'), 'wf_score'),
	array($tLang->lang('th_wf_title'), 'wf_title'),
	array($tLang->lang('th_wf_login'), 'wf_login'),
	array($tLang->lang('th_wf_status')),
);

$wbid = Common::getGetString('wbid');

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers);
foreach ($tVars['flags'] as $flag)
{
	$flag instanceof WC_Warflag;
	$fid = $flag->getID();
	echo GWF_Table::rowStart();
	$edit = GWF_Button::edit($flag->hrefEdit());
	echo GWF_Table::column($edit);
	echo GWF_Table::column($flag->getVar('wf_order'), 'gwf_num');
	$up = sprintf('<a href="%sindex.php?mo=WeChall&me=Warflags&up=%s&wbid=%s">^</a>', GWF_WEB_ROOT, $fid, $wbid);
	$down = sprintf('<a href="%sindex.php?mo=WeChall&me=Warflags&down=%s&wbid=%s">v</a>', GWF_WEB_ROOT, $fid, $wbid);
	echo GWF_Table::column("{$up}<br/>{$down}", 'gwf_num');
	echo GWF_Table::column($flag->display('wf_cat'));
	echo GWF_Table::column($flag->getVar('wf_score'), 'gwf_num');
	echo GWF_Table::column($flag->display('wf_title'));
	echo GWF_Table::column($flag->display('wf_login'));
	echo GWF_Table::column($flag->display('wf_status'));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

echo GWF_Button::wrapStart();
echo GWF_Button::add($tLang->lang('btn_add_warflag'), $tVars['href_add']);
echo GWF_Button::wrapEnd();

if (isset($tVars['form_csv']))
{
	echo $tVars['form_csv'];
}
