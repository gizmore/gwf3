<?php
#echo $tVars['form_wipe'];

echo $tVars['pagemenu'];

$headers = array(
	array($tLang->lang('th_ssyu_id'), 'ssyu_id', 'DESC'),
	array($tLang->lang('th_ssyu_fiscale'), 'ssyu_fiscale', 'ASC'),
	array($tLang->lang('th_ssyu_firstname'), 'ssyu_firstname', 'ASC'),
	array($tLang->lang('th_ssyu_lastname'), 'ssyu_lastname', 'ASC'),
	array($tLang->lang('th_ssyu_city'), 'ssyu_city', 'ASC'),
	array($tLang->lang('th_ssyu_businame'), 'ssyu_businame', 'ASC'),
	array($tLang->lang('th_ssyu_busicity'), 'ssyu_busicity', 'ASC'),
);

echo GWF_Table::start();

echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);

$tVars['module'] instanceof GWF_Module;

foreach ($tVars['users'] as $user)
{
	$uid = $user->getID();
	$hrefForms = $tVars['module']->getMethodURL('Staff', '&forms='.$uid);
	
	echo GWF_Table::rowStart();
	echo GWF_Table::column(GWF_HTML::anchor($hrefForms, $uid));
	echo GWF_Table::column(GWF_HTML::anchor($hrefForms, $user->display('ssyu_fiscale')));
	echo GWF_Table::column(GWF_HTML::anchor($hrefForms, $user->display('ssyu_firstname')));
	echo GWF_Table::column(GWF_HTML::anchor($hrefForms, $user->display('ssyu_lastname')));
	echo GWF_Table::column(GWF_HTML::anchor($hrefForms, $user->display('ssyu_city')));
	echo GWF_Table::column(GWF_HTML::anchor($hrefForms, $user->display('ssyu_businame')));
	echo GWF_Table::column(GWF_HTML::anchor($hrefForms, $user->display('ssyu_busicity')));
	echo GWF_Table::rowEnd();
}

echo GWF_Table::end();

echo $tVars['pagemenu'];
?>
