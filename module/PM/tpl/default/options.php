<?php
echo GWF_Button::wrapStart();
echo GWF_Button::generic($tLang->lang('btn_auto_folder'), $tVars['href_auto_folder']);
echo GWF_Button::wrapEnd();

echo $tVars['form'];

if (count($tVars['ignores']) > 0)
{
	$headers = array(
		array($tLang->lang('th_user_name')),#, 'user_name', 'ASC'),
		array($tLang->lang('th_reason')),#, 'pmi_reason', 'ASC'),
		array($tLang->lang('th_actions')),
	);
	echo GWF_Table::start();
	echo GWF_Table::displayHeaders1($headers);
	foreach ($tVars['ignores'] as $row)
	{
		echo GWF_Table::rowStart();
		$del_href = GWF_WEB_ROOT.'index.php?mo=PM&me=Options&unignore='.urlencode($row[0]);
		echo GWF_Table::column(GWF_HTML::display($row[0]));
		echo GWF_Table::column(GWF_HTML::display($row[1]));
		echo GWF_Table::column(GWF_Button::delete($del_href));
		echo GWF_Table::rowEnd();
	}
	echo GWF_Table::end();
}

echo $tVars['form_ignore'];
?>
