<?php
echo $tVars['site_quickjump'];
$headers = array(
	array($tLang->lang('th_userhist_date')),
	array($tLang->lang('th_user_name')),
	array($tLang->lang('th_userhist_comment')),
);
echo $tVars['pagemenu'];
$result = $tVars['result'];
$hist = new WC_HistoryUser2(false);
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, '');
while (false !== ($row = $hist->fetch($result, GDO::ARRAY_O)))
{
	echo GWF_Table::rowStart();
	echo GWF_Table::column($row->displayDate());
	echo GWF_Table::column($row->displayUser());
	echo GWF_Table::column($row->displayComment());
	echo GWF_Table::rowEnd();
}
$hist->free($result);
echo GWF_Table::end();
echo $tVars['pagemenu'];
?>