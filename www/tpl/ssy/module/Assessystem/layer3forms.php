<?php
echo $tVars['pagemenu'];

$headers = array(
	array($tLang->lang('th_ssyf_id'), 'ssyf_id', 'DESC'),
	array($tLang->lang('th_ssyf_date'), 'ssyf_date', 'ASC'),
	array($tLang->lang('th_ssyf_status'), 'ssyf_status', 'ASC'),
	array($tLang->lang('th_ssyf_studio'), 'ssyf_studio', 'ASC'),
	array($tLang->lang('th_ssyf_ricavi'), 'ssyf_ricavi', 'ASC'),
	array($tLang->lang('th_ssyf_subricavi'), 'ssyf_subricavi', 'ASC'),
);

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);

$data = array();
foreach ($tVars['forms'] as $form)
{
	$form instanceof SSY_Form;
	$fid = $form->getID();
	$hrefExport = $tVars['module']->getMethodURL('Staff', '&export='.$fid);
	
	echo GWF_Table::rowStart();
	echo GWF_Table::column(GWF_HTML::anchor($hrefExport, $fid));
	echo GWF_Table::column(GWF_HTML::anchor($hrefExport, $form->displayDate()));
	echo GWF_Table::column(GWF_HTML::anchor($hrefExport, $form->displayStatus($tVars['module'])));
	echo GWF_Table::column(GWF_HTML::anchor($hrefExport, $form->display('ssyf_studio')));
	echo GWF_Table::column(GWF_HTML::anchor($hrefExport, $form->display('ssyf_ricavi')));
	echo GWF_Table::column(GWF_HTML::anchor($hrefExport, $form->display('ssyf_subricavi')));
	echo GWF_Table::rowEnd();
}

echo GWF_Table::end();
?>
