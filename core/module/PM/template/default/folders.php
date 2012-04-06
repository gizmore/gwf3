<?php
$headers = array(
	array($tLang->lang('th_pmf_name'), 'pmf_name', 'ASC'),
	array($tLang->lang('th_pmf_count'), 'pmf_count', 'DESC'),
	array(),
);
//$headers = GWF_Table::getHeaders2($headers, $tVars['sort_url']);
echo GWF_Form::start($tVars['folder_action']);
echo GWF_CSRF::hiddenForm('PM_REM_FOLDER');
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['folders'] as $row)
{
	$foldername = $row->display('pmf_name');
	$folderid = $row->getVar('pmf_id');
	$href = $row->getOverviewHREF();
	echo GWF_Table::rowStart();
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, $foldername), 'ri');
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, $row->getVar('pmf_count')), 'gwf_num');
	echo GWF_Table::column(GWF_Form::checkbox("folder[$folderid]", false));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::rowStart();
echo GWF_Table::column(GWF_Form::submit('delete_folder', $tLang->lang('btn_delete')), 'ri', 3);
echo GWF_Table::rowEnd();

echo GWF_Table::end();
echo GWF_Form::end();

?>

